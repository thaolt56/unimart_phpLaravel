@extends('layouts.admin')
@section('content')

<div id="content" class="container-fluid">
     @if (session('status'))
        <div class="alert alert-primary" role="alert">
            {{session('status')}}
        </div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách vai trò</h5>
           
        </div>
        <div class="card-body">
            {{-- <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Kích hoạt<span class="text-muted">()</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Vô hiệu hóa<span class="text-muted">()</span></a>
           
            </div> --}}
            @if ($roles->total()>0)
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                        
                            <th scope="col">#</th>
                            <th scope="col">Tên vai trò</th>
                            <th scope="col">Mô tả</th>                          
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                     @php
                         $t=0;
                     @endphp
                    @foreach ($roles as $role)
                        @php
                            $t++;
                        @endphp
                        <tr>                         
                            <td scope="row">{{$t}}</td>
                            <td>{{$role->name}}</td>
                            <td>{!!$role->display_name!!}</td>
                            <td>{{date('d/m/Y', strtotime($role->created_at))}}</td>
                            <td>
                                <a href="{{route('roles.edit',$role->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                <a href="{{route('roles.delete',$role->id)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                               
                            </td>
                         </tr>
                        
                    @endforeach
                    </tbody>
                </table>
            @else
                <td><p>Không tồn tại bản ghi!</p></td>
            @endif
                 
            
        </div>
        {{$roles->links()}}
    </div>
</div>
@endsection
