<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CustomerRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Exception;

class CustomerController extends Controller
{
    /**
     * List all customers
     */
    public function index(): JsonResponse
    {
        try {
            $customers = User::with('milkTypes')->get();

            return response()->json([
                'message' => $customers->isEmpty() ? 'No customers found' : 'Customers retrieved successfully',
                'customers' => $customers
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch customers',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show single customer
     */
    public function show(User $user): JsonResponse
    {
        try {
            return response()->json([
                'message'  => 'Customer retrieved successfully',
                'customer' => $user->load('milkTypes')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch customer',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new customer
     */
    public function store(CustomerRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $customer = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'] ?? null,
                'phone'    => $validated['phone'] ?? null,
                'flat_no'  => $validated['flat_no'] ?? null,
                'status'   => $validated['status'] ?? 1,
                'password' => bcrypt('password'),
            ]);

            if (!empty($validated['milk_types'])) {
                $pivotData = collect($validated['milk_types'])->mapWithKeys(function ($item) {
                    return [
                        $item['id'] => [
                            'default_qty' => $item['default_qty'],
                            'rate'        => $item['rate'] ?? null,
                        ]
                    ];
                })->toArray();

                $customer->milkTypes()->sync($pivotData);
            }

            return response()->json([
                'message'  => 'Customer created successfully',
                'customer' => $customer->load('milkTypes')
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create customer',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update customer
     */
    public function update(CustomerRequest $request, User $user): JsonResponse
    {
        try {
            $validated = $request->validated();
            $user->update($validated);

            if (!empty($validated['milk_types'])) {
                $pivotData = collect($validated['milk_types'])->mapWithKeys(function ($item) {
                    return [
                        $item['id'] => [
                            'default_qty' => $item['default_qty'],
                            'rate'        => $item['rate'] ?? null,
                        ]
                    ];
                })->toArray();

                $user->milkTypes()->sync($pivotData);
            }

            return response()->json([
                'message'  => 'Customer updated successfully',
                'customer' => $user->load('milkTypes')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update customer',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete customer
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();

            return response()->json([
                'message'  => 'Customer deleted successfully',
                'customer' => $user->load('milkTypes')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete customer',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
