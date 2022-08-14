@extends('layouts.admin')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div id="content" class="container-fluid">
   
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm người dùng
        </div>
        <div class="card-body">
        
            <form action="{{url('admin/users/store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                    @error('name')
                    <small class="text-danger">{{$message}}</small>
                @enderror
                </div>
               
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{old('email')}}">
                    @error('email')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password">
                    @error('password')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Nhập lại mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirmation" required id="password-confirm">
                    @error('password_confirm')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Nhóm quyền</label>
                    <select class="form-control roles_select2" id="" multiple="multiple" name="roles[]">
                        <option>Chọn quyền</option>
                        @if ($roles)
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}">{!!$role->display_name!!}</option>
                            @endforeach
                        @endif
                       
                    </select>
                    @error('roles')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
       $(function(){
        $(".roles_select2").select2({
        tags: true,
        tokenSeparators: [',', ' ']
        });
        $(".roles_select2").select2({
        placeholder: "Chọn vai trò"
        });
       })
</script>
@endsection