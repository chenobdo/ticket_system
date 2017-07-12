<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;
use Barryvdh\DomPDF\PDF;

class AdminCheckController extends Controller
{
    public function index()
    {
        return view('admin.check.index');
    }

    public function package(Request $request)
    {
        $contractnos = $request->input('contractnos');
        $clients = Client::whereIn('contractno', $contractnos)->get();

        foreach ($clients as $client) {
            $pdf = PDF::loadView('admin.check.template', ['client' => $client]);
            return $pdf->stream();
        }
    }
}
