<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class AdminCheckController extends Controller
{
    public function index()
    {
        return view('admin.check.index');
    }

    public function package(Request $request)
    {
        dd($request->all());
    }
}
