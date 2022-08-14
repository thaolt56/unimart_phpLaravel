<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{   
    function __construct()
    {
        $this->middleware(function($request, $next){
            session(['module_active' =>'users']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời'
        ];

        if ($status == 'trash') {
            $list_act = [
                'forceDelete' => 'Xóa vĩnh viễn',
                'restore' => 'Khôi phục'
            ];
            $users = User::onlyTrashed()->paginate(5);
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(5);
        }

        $count_status_active = User::count();
        $count_status_trash = User::onlyTrashed()->count();
        $count = [$count_status_active, $count_status_trash];
        //  return dd($users);
        $temp = $users->currentPage();
        return view('admin.users.list', compact('users', 'count', 'temp', 'list_act'));
    }

    function add(Request $request)
    {
        //    return $request->input();
        $roles = role::all();
        // return dd($roles);
        return view('admin.users.add',compact('roles'));
    }
    function store(Request $request)
    {
        // return $request->input();
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'roles' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự ',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự',
                'confirmed' => 'xác nhận mật khẩu không thành công'
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'roles' => 'Vai trò'

            ]
        );
       

        // insert database
        try{
            DB::beginTransaction();
            $user =  User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
    
            $roles_id = $request ->input('roles');
            $user->roles()->attach($roles_id);
            DB::commit();
        }catch(\Exception $exception){
            Log::error("message". $exception->getMessage()."---line".$exception->getLine());
            DB::rollBack();
        }
    
        return redirect('admin/users/list')->with('status', 'Thêm thành viên thành công!');
    }

    function delete(Request $request)
    {

        if (Auth::id() != $request->id) {

            $id = $request->id;
            User::destroy($id);
           
            return redirect('admin/users/list')->with('status', 'Bạn đã xóa bản ghi thành công!');
        } else {
            return redirect('admin/users/list')->with('status', 'Bạn không thể xóa chính mình ra khỏi hệ thống!');
        }
    }
    function action(Request $request)
    {
        // return $request->input();
        $list_check = $request->input('list_checkbox');
        if (!empty($list_check)) {
            foreach ($list_check as $k => $v) {
                if (Auth::id() == $v) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                $action = $request->input('select_action');
                if ($action == '0') {
                    return redirect('admin/users/list')->with('status', 'Bạn chưa chọn tác vụ!');
                }
                if ($action == 'delete') {
                    User::destroy($list_check);
                    return redirect('admin/users/list')->with('status', 'Bạn đã xóa bản ghi thành công!');
                }
                if ($action == 'restore') {
                    User::onlyTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/users/list')->with('status', 'Bạn đã khôi phục bản ghi thành công!');
                }
                if ($action == 'forceDelete') {
                    User::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    DB::table('role_user')->whereIn('user_id',$list_check)->Delete();
                    return redirect('admin/users/list')->with('status', 'Bạn đã xóa vĩnh viễn bản ghi thành công!');
                }
            } else {
                return redirect('admin/users/list')->with('status', 'Bạn không thể tác vụ chính mình trên hệ thống!');
            }
        } else {
            return redirect('admin/users/list')->with('status', 'Bạn cần chọn bản ghi !');
        }
    }

    function edit(Request $request)
    {   

        $id = $request->id;
      $user= User::find($id);
      $rolesOfUser = $user->roles;

      $roles = role::all();
        return view('admin.users.edit', compact('user','rolesOfUser','roles','rolesOfUser'));
    }
    function update(Request $request, $id){
        // return $request->input();
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',

            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhât :min kí tự ',
                'max' => ':attribute có độ dài nhiều nhất :max kí tự',
                'confirmed' => 'xác nhận mật khẩu không thành công'
            ],
            [
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu',

            ]
        );

        $id = $request->id;
        try{
            DB::beginTransaction();
            User::where('id', $id)->update([
                'name' =>$request->input('name'),
                'password'=>Hash::make($request->input('password')),
            ]);
            $user = User::find($id);
            $roles_id = $request ->input('roles');
            $user->roles()->sync($roles_id);
            DB::commit();
        }catch(\Exception $exception){
            Log::error("message". $exception->getMessage()."---line".$exception->getLine());
            DB::rollBack();
        }
        

        return redirect('admin/users/list')->with('status', 'Bạn đã chỉnh sửa thành công!');
    }
}
