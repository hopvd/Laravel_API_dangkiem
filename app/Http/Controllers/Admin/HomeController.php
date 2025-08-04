<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = auth()->user();

    }
    public function index()
    {
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id','=',Session::get('loginId'))->first();
        }
        $data['title'] = "Dashboard";
        $data['breadcrumb'] = 'Dashboard';
        return view('admin.dashboard', $data);
    }
}
