<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Delivery;
use App\Models\User;
use App\Models\MilkType;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * GET /bills
     * List bills by customer/month
     */
    public function index(Request $request)
    {
        $query = Bill::with(['customer', 'items.milkType']);

        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->has('month')) {
            $query->where('month', $request->month);
        }

        $bills = $query->get();

        return response()->json([
            'message' => $bills->isEmpty() ? 'No bills found' : 'Bills retrieved successfully',
            'bills' => $bills
        ]);
    }

    /**
     * POST /bills/generate?month=2025-09
     * Generate bills from deliveries
     */
    public function generate(Request $request)
    {
        $month = $request->month ?? date('Y-m');
        $deliveries = Delivery::with('milkType', 'customer')
            ->whereMonth('date', substr($month, 5, 2))
            ->whereYear('date', substr($month, 0, 4))
            ->get();

        $billsData = [];

        DB::beginTransaction();
        try {
            $customers = $deliveries->groupBy('customer_id');

            foreach ($customers as $customerId => $customerDeliveries) {
                $totalLiters = $customerDeliveries->sum('delivered_qty');
                $bill = Bill::create([
                    'customer_id' => $customerId,
                    'month' => $month,
                    'total_liters' => $totalLiters,
                    'amount' => 0, // will calculate below
                    'status' => 'pending'
                ]);

                $amount = 0;
                $milkGroups = $customerDeliveries->groupBy('milk_type_id');
                foreach ($milkGroups as $milkTypeId => $milkDeliveries) {
                    $liters = $milkDeliveries->sum('delivered_qty');
                    $rate = MilkType::find($milkTypeId)->default_rate ?? 0;
                    $itemAmount = $liters * $rate;
                    $amount += $itemAmount;

                    BillItem::create([
                        'bill_id' => $bill->id,
                        'milk_type_id' => $milkTypeId,
                        'total_liters' => $liters,
                        'rate' => $rate,
                        'amount' => $itemAmount
                    ]);
                }

                $bill->update(['amount' => $amount]);
                $billsData[] = $bill->fresh();
            }

            DB::commit();

            return response()->json([
                'message' => 'Bills generated successfully',
                'bills' => $billsData
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to generate bills',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /bills/{id}
     * Get single bill with items
     */
    public function show($id)
    {
        $bill = Bill::with(['customer', 'items.milkType'])->find($id);

        if (!$bill) {
            return response()->json([
                'message' => 'Bill not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Bill retrieved successfully',
            'bill' => $bill
        ]);
    }
}
