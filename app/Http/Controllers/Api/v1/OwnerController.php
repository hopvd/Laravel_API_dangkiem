<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        dd($request->input('page'));
        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $limit = !empty($request->input('limit')) ? $request->input('limit') : 10;

        // $owner = Owner::all();
        $owner = Owner::paginate(2);
        // dd($owner);

        return response()->json([
            'data' => $owner,
            'status' => 'success'
        ]);    }

    public function store(Request $request)
    {
        $owner = new Owner();
        $owner->name = $request->input('name');
        $owner->birthday = $request->input('birthday');
        $owner->address = $request->input('address');
        $owner->phone = $request->input('phone');
        $owner->cccd = $request->input('cccd');
        $owner->type = $request->input('type');
        $owner->location = $request->input('location');

        $owner->save();

        return response()->json($owner);
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

        $owner->name = $request->input('name');
        $owner->birthday = $request->input('birthday');
        $owner->address = $request->input('address');
        $owner->phone = $request->input('phone');
        $owner->cccd = $request->input('cccd');
        $owner->type = $request->input('type');
        $owner->location = $request->input('location');
        $owner->save();

        return response()->json($owner);
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
