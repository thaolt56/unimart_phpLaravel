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
            <h5 class="m-0 ">Danh sách trang</h5>
            <div class="form-search form-inline">
                <form action="">
                    <input type="text" class="form-control form-search" placeholder="Tìm kiếm" name="keyword" value="{{request()->input('keyword')}}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{$count[1]}}))</span></a>
               
            </div>
            <form action="{{url('admin/page/action_checkbox')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="select_action">
                        <option value="0">Chọn</option>
                        @foreach ($list_act as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                     </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                @if ($pages->total()>0)
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                          $t=0;  
                        @endphp
                        @foreach ($pages as $page)
                        @php
                          $t++;  
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_checkbox[]" value="{{$page->id}}">
                            </td>
                            <td scope="row">{{$t}}</td>
                            <td>{{$page->title}}</td>
                            <td>{{$page->created_at}}</td>
                            <td>{{$page->creator}}</td>
                            <td>
                                <a href="{{route('page.edit', $page->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                <a href="{{route('page.delete',$page->id)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
    
                        </tr>
                            
                        @endforeach
                        
    
    
                    </tbody>
                </table>
                @else
                <td>Không tồn tại dữ liệu trang</td>
                    
                @endif
            </form>
            
            
            {{$pages->links()}}
        </div>
    </div>
</div>
@endsection