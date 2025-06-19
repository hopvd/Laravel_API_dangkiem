<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $limit = !empty($request->input('limit')) ? $request->input('limit') : 10;

        $vehicle = Vehicle::paginate(10);

        return response()->json([
            'data' => $vehicle,
            'status' => 'success'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'produce_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'owner_id' => 'required|exists:owners,id',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vehicle = Vehicle::insert($request->all());
        if (!$vehicle) {
            return response()->json([
                'status' => 'error',
                'message' => "Can't add data!!"
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'data' => $request->all()
        ]);
    }


    public function show($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'message' => 'Vehicle not found',
                'status' => 'error'
            ], 404);
        }

        return response()->json([
            'data' => $vehicle,
            'status' => 'success'
        ]);
    }

    public function getByOwnerId(Request $request) {
        $owner_id = $request->input('owner_id') ?? 0;

        $vehicles = Vehicle::with('owner')
                    ->where('owner_id', $owner_id)
                    ->get();
        if (!$vehicles) {
            return response()->json([
                'message' => 'Vehicle not found',
                'status' => 'error'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'messaage' => 'Thanh cong',
            'data' => $vehicles
        ]);
    }

    public function getByLicensePlate(Request $request) {
        $validator = Validator::make($request->all(), [
            'license_plate' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $license_plate = $request->input('license_plate') ?? 0;
        $vehicles = Vehicle::getByLicensePlate($license_plate);
        if (!$vehicles) {
            return response()->json([
                'message' => 'Vehicle not found',
                'status' => 'error'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'messaage' => 'Thanh cong',
            'data' => $vehicles
        ]);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'message' => 'Vehicle not found',
                'status' => 'error'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|required|string|max:255',
            'produce_year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'owner_id' => 'sometimes|required|exists:owners,id',
            'license_plate' => 'sometimes|required|string|max:255|unique:vehicles,license_plate,' . $id
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vehicle->update($request->all());

        return response()->json([
            'data' => $vehicle,
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'message' => 'Vehicle not found',
                'status' => 'error'
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'message' => 'Vehicle deleted',
            'status' => 'success'
        ]);
    }
}
