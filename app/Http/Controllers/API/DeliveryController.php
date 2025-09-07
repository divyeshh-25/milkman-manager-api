<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\DeliveryRequest;
use App\Models\Delivery;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class DeliveryController extends Controller
{
    /**
     * List deliveries with optional filters (date/month)
     */
    public function index(Request $request)
    {
        try {
            $query = Delivery::with(['customer', 'milkType']);

            if ($request->has('date')) {
                $query->whereDate('date', $request->date);
            }

            if ($request->has('month')) {
                $query->whereMonth('date', $request->month)
                      ->whereYear('date', $request->year ?? now()->year);
            }

            $deliveries = $query->get();

            return response()->json([
                'message' => $deliveries->isEmpty() ? 'No deliveries found' : 'Deliveries retrieved successfully',
                'deliveries' => $deliveries
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new delivery
     */
    public function store(DeliveryRequest $request)
    {
        try {
            $validated = $request->validated();

            // Check if the customer has this milk type
            $customer = User::findOrFail($validated['customer_id']);
            if (!$customer->milkTypes()->where('milk_type_id', $validated['milk_type_id'])->exists()) {
                return response()->json([
                    'message' => 'This milk type is not assigned to the customer'
                ], 422);
            }

            $delivery = Delivery::create($validated);

            return response()->json([
                'message' => 'Delivery created successfully',
                'delivery' => $delivery->fresh()
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing delivery
     */
    public function update(DeliveryRequest $request, Delivery $delivery)
    {
        try {
            $validated = $request->validated();

            // Check if the customer has this milk type
            $customer = User::findOrFail($validated['customer_id']);
            if (!$customer->milkTypes()->where('milk_type_id', $validated['milk_type_id'])->exists()) {
                return response()->json([
                    'message' => 'This milk type is not assigned to the customer'
                ], 422);
            }

            $delivery->update($validated);

            return response()->json([
                'message' => 'Delivery updated successfully',
                'delivery' => $delivery->fresh()
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a delivery
     */
    public function destroy(Delivery $delivery)
    {
        try {
            $delivery->delete();

            return response()->json([
                'message' => 'Delivery deleted successfully'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
