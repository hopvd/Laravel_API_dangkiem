<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
	public $res_body = [];
	public $token = '';
	public $_redis;
	public $user_login = '';
	public $_message = [];
    const RESPONSE_SUCCESS = 200;
	const RESPONSE_EXIST = 201;
	const RESPONSE_REQUEST_ERROR = 400;
	const RESPONSE_LOGIN_ERROR = 401;
	const RESPONSE_LOGIN_DENIED = 403;
	const RESPONSE_NOT_EXIST = 404;
	const RESPONSE_LIMITED = 406;
	const RESPONSE_SERVER_ERROR = 500;
    public function __construct() {
        // dd(vars: request()->user()->role);
    }

    

}
