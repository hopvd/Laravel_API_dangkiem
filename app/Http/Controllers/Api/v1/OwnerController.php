<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $limit = !empty($request->input('limit')) ? $request->input('limit') : 10;

        $owner = Owner::paginate($limit);
        // dd($owner);

        return response()->json([
            'data' => $owner,
            'status' => 'success'
        ]);    
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'cccd' => 'required|string|max:255|unique:owners,cccd'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $owner = Owner::insert($request->all());
        if (!$owner) {
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
        $owner = Owner::find($id);

        if (!$owner) {
            return response()->json([
                'message' => 'Owner not found',
                'status' => 'error'
            ], 404);
        }

        return response()->json($owner);
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::find($id);

        if (!$owner) {
            return response()->json([
                'message' => 'Owner not found',
                'status' => 'error'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:255',
            'cccd' => 'sometimes|required|string|max:255|unique:owners,cccd,' . $id
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $owner->update($request->all());

        return response()->json([
            'data' => $owner,
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $owner = Owner::find($id);

        if (!$owner) {
            return response()->json([
                'message' => 'Owner not found',
                'status' => 'error'
            ], 404);
        }

        $owner->delete();

        return response()->json([
            'message' => 'Owner deleted',
            'status' => 'success'
        ]);
    }
}
