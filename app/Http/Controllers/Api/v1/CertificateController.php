<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    protected $_data;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->_data = new Certificate();
    }

    public function index()
    {
        $certificate = $this->_data->select(
            ['certificates.id',
                'certificates.code',
                'certificates.start_date',
                'certificates.expired_date',
                'vehicles.name',
                'users.name',
                'certificates.created_at',
                'certificates.updated_at']
        )
            ->join('vehicles', 'certificates.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'certificates.user_id', '=', 'users.id')
            ->get();

        return response()->json($certificate);
    }

    public function getList(Request $request)
    {
        $certificate = $this->_data->getData($request->input());
//        dd($certificate);

        return response()->json($certificate);
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
        $certificate = $this->_data->findById($id);

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
        $certificate = Certificate::find($id);

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
        $certificate = Certificate::find($id);

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
