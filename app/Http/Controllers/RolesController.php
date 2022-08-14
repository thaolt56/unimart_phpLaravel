<?php

namespace App\Http\Controllers;

use App\role;
use App\permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'roles']);
            return $next($request);
        });
    }
    function list()
    {
        $roles =  role::paginate(10);
        //    return dd($roles);
        return view('admin.roles.list', compact('roles'));
    }

    function delete(Request $request)
    {
        $id = $request->id;
        role::destroy($id);
        DB::table('permission_roles')->where('role_id', $id)->Delete();
        return redirect()->back()->with('status', 'Đã xóa thành công bản ghi!');
    }

    function add()
    {
        $permission_parents = permission::where('parent_id', '=', 0)->get();

        return view('admin.roles.add', compact('permission_parents'));
    }
    function store(Request $request)
    {
        // return $request->input();
        $request->validate(
            [
                'name' => 'required|max:255',
                'display_name' => 'required',
                'permission_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự hoặc (Kb)',
            ],
            [
                'name' => 'Tên vai trò',
                'display_name' => 'Mô tả vai trò',
                'permission_id' => 'quyền chi tiết',

            ]
        );
        $input = [
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),


        ];
        $permission_ids = $request->input('permission_id');
        $role = role::create($input);
        $role->permission()->attach($permission_ids);

        return redirect('admin/roles/list')->with('status', 'Thêm vai trò thành công!');
    }
    function edit(Request $request)
    {
        $permission_parents = permission::where('parent_id', '=', 0)->get();
        $id = $request->id;
        $role = role::find($id);
        $permission_checked = $role->permission;


        return view('admin.roles.edit', compact('permission_parents', 'role', 'permission_checked'));
    }
    function update(Request $request)
    {
        //   return $request->input();
        //   return $request->id;
        $id = $request->id;
        $request->validate(
            [
                'name' => 'required|max:255',
                'display_name' => 'required',
                'permission_id' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự hoặc (Kb)',
            ],
            [
                'name' => 'Tên vai trò',
                'display_name' => 'Mô tả vai trò',
                'permission_id' => 'quyền chi tiết',

            ]
        );
        $input = [
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),


        ];


        $permission_ids = $request->input('permission_id');
        role::where('id', $id)->update($input);
        $role = role::find($id);

        $permission_ids = $request->input('permission_id');
        $role->permission()->sync($permission_ids);

        return redirect('admin/roles/list')->with('status', 'Chỉnh sửa vai trò thành công!');
    }

    function permission()
    {
        return view('admin.roles.permission');
    }

    function permission_store(Request $request)
    {
        //   return  $request->input();
        $request->validate(
            [
                'module' => 'required',
                'permission_child' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',

            ],
            [
                'module' => 'Tên nhóm',
                'permission_child' => 'quyền chi tiết',

            ]
        );
      
        $permission_parent=  permission::create([
            'name' => $request->input('module'),
            'display_name' =>  $request->input('module'),
            'parent_id' => 0, 
        ]);

        $parent_id = $permission_parent->id;
      
        foreach($request->input('permission_child') as $item ){
            permission::create([
                'name' =>$item,
                'display_name' => $item ,
                'parent_id' => $parent_id, 
                'key_code' => $request->input('module').'_'.$item,
            ]);
        }

        return redirect()->back()->with('status','Thêm dữ liệu thành công!');
    }
}
