<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        // dd(11111111);
        if($request->user()->role!=1){
            return response()->json([
                'message'=>'You do not have permission',
                'status' => 'error'
            ],403);
        } else {
            $users = User::all();
            return response()->json([
                'status' => 'success',
                'data' => $users
            ], 200);
        }
    }

    public function store(Request $request)
    {
        if($request->user()->role!=1){
            return response()->json(['message'=>'You do not have permission', 'status' => 'error'],403);
        }
        try {
            $data = $request->only([
                'email',
                'name',
                'password',
                'manager',
                'address',
                'phone',
                'role',
                'status'
            ]);

            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show(Request $request, $id)
    {
        if ($request->user()->role == 1) {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                    'status' => 'error'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $user
            ], 200);
        } elseif ($request->user()->id == $id) {
            $user = User::find($id);

            return response()->json([
                'status' => 'success',
                'data' => $user
            ], 200);
        } else {
            return response()->json(['message'=>'You do not have permission', 'status'=>'error'],403);
        }
    }

    public function showme(Request $request)
    {
        $user = User::find($request->user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'manager',
            'address',
            'phone',
            'role',
            'status'
        ]);

        if ($request->user()->role == 1) {
            try {
                $user = User::findOrFail($id);
                if (!empty($data['password'])) {
                    $data['password'] = bcrypt($data['password']);
                }
                $user->update($data);

                return response()->json([
                    'status' => 'success',
                    'message' => 'User updated successfully',
                    'user' => $user
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update user',
                    'error' => $e->getMessage()
                ], 500);
            }
        } elseif ($request->user()->id == $id) {
            $user = User::find($id);
            $user->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'user' => $user
            ], 200);
        } else {
            return response()->json(['message'=>'You do not have permission', 'status' => 'error'],403);
        }
    }

    public function destroy(Request $request,$id)
    {
        if($request->user()->role!=1){
            return response()->json(['message'=>'You do not have permission', 'status' => 'error'],403);
        }
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted',
            'status' => 'success'
        ], 200);
    }
}
