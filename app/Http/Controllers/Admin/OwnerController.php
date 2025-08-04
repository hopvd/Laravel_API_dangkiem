<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class OwnerController extends Controller
{
    //
    public function index()
    {
        // Logic to display the list of owners
        return view('admin.owners.index');
    }
}
