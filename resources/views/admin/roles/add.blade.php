@extends('layouts.admin')
@section('css')
    <style>
        input[type="checkbox"]{
            transform: scale(1.2)
        }
    </style>
@endsection

@section('content')
<div id="content" class="container-fluid">
   
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm Vai trò (Roles)
        </div>
        <div class="card-body">
        
            <form action="{{route('roles.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Tên vai trò</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                    @error('name')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="example">Mô tả vai trò</label>
                    <textarea class="form-control" id="example" name="display_name" rows="3"></textarea>
                   
                    @error('display_name')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                
                <div class="row">
                    
                    <div class="col-md-12">
                        <label for="">
                            <input type="checkbox" value="" class="check_all">
                           <strong>Check all</strong>
                        </label>
                    @foreach ($permission_parents as $permission_parent)
                    <div class="card card_checkbox mb-2">
                        <div class="card-header text-white bg-info">
                           <label for="">
                               <input type="checkbox" value="" class="checkbox_wrapper">
                              {{$permission_parent->name}}
                           </label>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($permission_parent->permission_child as $item)
                                <div class="col-md-3">
                                    <label for="">
                                       <input type="checkbox" value="{{$item->id}}" name="permission_id[]" class="check_box_child">
                                       
                                    </label>
                                    {{$item->name}}
                                </div>
                                @endforeach
                               
                                
                            </div>
                        </div>
                        
                      
                    </div>
                    @endforeach
                    @error('permission_id')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                        
                    </div>
                </div>
              

                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(".checkbox_wrapper").on('click',function(){
            $(this).parents('.card_checkbox').find('.check_box_child').prop('checked',$(this).prop('checked'));
        })

        $('.check_all').on('click',function(){
            $(this).parents().find('.check_box_child').prop('checked',$(this).prop('checked'));
            $(this).parents().find('.checkbox_wrapper').prop('checked',$(this).prop('checked'));
        })
      
    </script>
@endsection
