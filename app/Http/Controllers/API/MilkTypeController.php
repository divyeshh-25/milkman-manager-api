<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MilkTypeRequest;
use App\Models\MilkType;

class MilkTypeController extends Controller
{
    public function index()
    {
        $milk_types = MilkType::all();

        return response()->json([
            'message' => $milk_types->isEmpty() ? 'No milk types found' : 'MilkTypes retrieved successfully',
            'milk_types' => $milk_types
        ], 200);
    }

    public function store(MilkTypeRequest $request)
    {
        try {
            $milk_type = MilkType::create($request->all());

            return response()->json([
                'message' => 'MilkType created successfully',
                'milk_type' => $milk_type
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(MilkType $milk_type)
    {
        return response()->json([
            'message' => 'MilkType retrieved successfully',
            'milk_type' => $milk_type
        ], 200);
    }

    public function update(MilkTypeRequest $request, MilkType $milk_type)
    {
        try {
            $milk_type->update($request->all());

            return response()->json([
                'message' => 'MilkType updated successfully',
                'milk_type' => $milk_type
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(MilkType $milk_type)
    {
        try {
            $milk_type->delete();

            return response()->json([
                'message' => 'MilkType deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
