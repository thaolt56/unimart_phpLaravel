@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if (session('status'))
        <div class="alert alert-primary" role="alert">
            {{session('status')}}
        </div>
        @endif
        <div class="card-header font-weight-bold">
            Tạo dữ liệu cho bảng quyền (permission)
        </div>
        <div class="card-body">
            <form action="{{route('permission.add')}}" method="POST">
                @csrf
               
              
                <div class="form-group">
                    <label for="">Chọn module</label>
                    <select class="form-control" id="" name="module">
                      <option value="">Chọn danh mục</option>
                         @foreach (config('permission.module_parent') as $item)
                           <option value="{{$item}}">{{$item}}</option>
                        @endforeach
                    </select>
                    @error('module')
                    <small class="text-danger"></small>
                    @enderror
                </div>
                <div class="card card_checkbox mb-2">
                    <div class="card-body">
                        <div class="row">
                            @foreach (config('permission.module_child') as $item)
                            <div class="col-md-3">
                                <label for="">
                                   <input type="checkbox" value="{{$item}}" name="permission_child[]" class="check_box_child">
                               </label>
                               {{$item}}
                            </div>
                            @endforeach
                           
                            
                        </div>
                        @error('permission_child')
                        <small class="text-danger"></small>
                        @enderror
                    </div>
                    
                  
                </div>

                <button type="submit" name="add_post" value="add" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection