<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Excel;

class AdminClientController extends Controller
{
    public function index()
    {
        $menucount = $this->menucount();

        $tickets = Ticket::orderBy('created_at', 'desc')->paginate(5);
        $categories = Category::all();
        $prioritys = Priority::all();
        $statuses = Status::all();

        return view('admin.tickets.index', compact('menucount', 'tickets', 'categories', 'statuses', 'prioritys'));
    }

    public function upload()
    {
        return view('admin.clients.upload');
    }

    public function store(Request $request)
    {
        $file = $request->file('file_name');
        $filename = $file->getRealPath();

        $rt = Excel::selectSheets('总表')->load($filename, function($reader) {

            // reader methods

        });

        dd($rt);
    }
}
