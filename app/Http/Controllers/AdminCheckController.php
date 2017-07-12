<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;

class AdminCheckController extends Controller
{
    public function index()
    {
        return view('admin.check.index');
    }

    public function package(Request $request)
    {
        $contractnos = $request->input('contractnos');
        $clients = Client::whereIn('contractnos', $contractnos)->get();
        dd($clients);
    }
}
