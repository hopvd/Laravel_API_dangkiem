<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.user.login', [
            'title' => 'Login',
        ]);
    }

    public function login(Request $request)
    {
//        dd($request->input());
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email','=',$request->email)->first();
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'))) {
            $request->session()->put('loginId', $user->id);
            return redirect(route('home'));
        }

        Session::flash('error', 'Email hoac Password khong chinh xac!');

        return redirect()->back();
    }
}
