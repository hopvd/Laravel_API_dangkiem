<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CertificateController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api');
    }

    public function index()
    {
        if (request()->user()->role == 1) {
            $certificate = Certificate::with(['vehicle', 'user'])->get();
        } else {
            $certificate = Certificate::with(['vehicle', 'user'])
                ->where('user_id', request()->user()->id)
                ->get();
        }

        if ($certificate->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No certificates found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $certificate
        ], 200);
    }

    public function getByVehicleId(Request $request)
    {
        $vehicleId = $request->input('vehicle_id');
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        if (request()->user()->role == 1) {
            $certificate = Certificate::with(['vehicle', 'user'])
                ->where('vehicle_id', $vehicleId)
                ->get();
        } else {
            $certificate = Certificate::with(['vehicle', 'user'])
                ->where('vehicle_id', $vehicleId)
                ->where('user_id', request()->user()->id)
                ->get();
        }
        if ($certificate->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No certificates found for this vehicle'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $certificate
        ], 200);
    }

    public function getByLicensePlate(Request $request)
    {
        $licensePlate = $request->input('license_plate');
        $validator = Validator::make($request->all(), [
            'license_plate' => 'required|exists:vehicles,license_plate'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        if (request()->user()->role == 1) {
            $certificate = Certificate::whereHas('vehicle', function($query) use ($licensePlate) {
                $query->where('license_plate', $licensePlate);
            })->with('vehicle:id,license_plate')->get();
        } else {
            $certificate = Certificate::whereHas('vehicle', function($query) use ($licensePlate) {
                $query->where('license_plate', $licensePlate);
            })->with('vehicle:id,license_plate')
            ->where('user_id', request()->user()->id)
            ->get();
        }
        if ($certificate->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No certificates found for this vehicle'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $certificate
        ], 200);
    
        


    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date',
            'expired_date' => 'required|date',
            'result' => 'required',
            'note' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data['user_id'] = $request->user()->id;

        $certi = Certificate::insert($data);
        if (!$certi) {
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
        $certificate = Certificate::with(['vehicle', 'user'])
                        ->where('id', $id)
                        ->where('user_id', request()->user()->id)
                        ->orWhere('user_id', 1) // Admin can see all certificates
                        ->first();

        if (!$certificate) {
            return response()->json([
                'message' => 'Certificate not found',
                'status' => 'error'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $certificate
        ]);    
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::where('id', $id)
                        ->where('user_id', request()->user()->id)
                        ->orWhere('user_id', 1) // Admin can see all certificates
                        ->first();

        if (!$certificate) {
            return response()->json([
                'message' => 'Certificate not found',
                'status' => 'error'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date',
            'expired_date' => 'required|date|',
            'result' => 'required',
            'note' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $certificate->update($request->all());

        return response()->json([
            'data' => $certificate,
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $certificate = Certificate::where('id', $id)
                        ->where('user_id', request()->user()->id)
                        ->orWhere('user_id', 1) // Admin can see all certificates
                        ->first();

        if (!$certificate) {
            return response()->json([
                'message' => 'Certificate not found',
                'status' => 'error'
            ], 404);
        }

        $certificate->delete();

        return response()->json([
            'message' => 'Certificate deleted',
            'status' => 'success'
        ]);
    }

    private function _genCode()
    {
        return str()->random(10);
    }
}
