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
            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search form-inline">
                <form action="" >
                
                    <input type="text" name="keyword" class="form-control form-search" placeholder="Tìm kiếm" value="{{request()->input('keyword')}}" >
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Kích hoạt<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{$count[1]}})</span></a>
                {{-- <a href="" class="text-primary">Trạng thái 3<span class="text-muted">(20)</span></a> --}}
            </div>
            <form action="{{url('admin/users/action')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="select_action">
                        <option value="0">Chọn</option>
                        @foreach ($list_act as $k=>$v)
                        <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                        
                        
                    </select>
                    <input type="submit" name="btn-action" value="Áp dụng" class="btn btn-primary">
                </div>
                @if ($users->total()>0)
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                     @php
                         $t=($temp-1)*2;
                     @endphp
                    @foreach ($users as $user)
                        @php
                            $t++;
                        @endphp
                        <tr>
                          <td>
                            <input type="checkbox" name="list_checkbox[]" value="{{$user->id}}">
                            </td>
                            <td scope="row">{{$t}}</td>
                            <td>{{$user->name}}</td>
                            
                            <td>{{$user->email}}</td>
                           
                            <td> @foreach ($user->roles as $item)
                                 {{$item->name}} 
                                @endforeach</td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <a href="{{route('user.edit', $user->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                @if (Auth::id() != $user->id)
                                <a href="{{route('user.delete',$user->id)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                         </tr>
                        
                        @endforeach
                    </tbody>
                </table>
                @else
                <td><p>Danh sách không tồn tại thành viên!</p></td>
                @endif
            </form>
            
            
            {{$users->links()}}
            {{-- <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">Trước</span>
                            <span class="sr-only">Sau</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav> --}}
        </div>
    </div>
</div>
@endsection
