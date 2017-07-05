<?php

namespace App\Http\Controllers;

use App\Permission;

use DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


class PermissionController extends Controller
{
    public function index()
    {
        return view('admin.permissions.index');
    }

    public function data()
    {
        return Datatables::of(Permission::query())->make(true);
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|unique:permissions,name',
            'display_name' => 'required',
            'description'  => 'required',
        ]);

        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        return redirect()->route('permissions.index')
                        ->with('success', '权限添加成功');
    }

    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.show', compact('permission'));
    }

    public function edit($id)
    {
        $permission = Permission::find($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'         => 'required',
            'display_name' => 'required',
            'description'  => 'required',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        return redirect()->route('permissions.index')
                        ->with('success', '权限更新成功');
    }

    public function destroy($id)
    {
        DB::table('permissions')->where('id', $id)->delete();

        return redirect()->route('permissions.index')
                        ->with('success', '权限删除成功');
    }
}
