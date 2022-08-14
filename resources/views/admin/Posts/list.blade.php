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
            <h5 class="m-0 ">Danh sách bài viết</h5>
            <div class="form-search form-inline">
                <form action="">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm" name="keyword">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
      
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'full'])}}" class="text-primary">Tất cả<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'public'])}}" class="text-primary">Công khai<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'pending'])}}" class="text-primary">Chờ duyệt<span class="text-muted">({{$count[2]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'destroy'])}}" class="text-primary">Xóa tạm thời<span class="text-muted">({{$count[3]}})</span></a>
            </div>
            <form action="{{url('admin/post/list_action')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="select">
                        <option value="">Chọn</option>
                       @if(!empty($list_act))
                        @foreach ($list_act as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                       @endif
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                 @if ($posts->total()>0)
                    <tbody>
                        @foreach ($posts as $post)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_checkbox[]" value="{{$post->id}}">
                            </td>
                            <td scope="row">1</td>
                            <td><img width="170px" src="{{asset($post->thumbnail)}}" alt=""></td>
                            <td><a href="">{{Str::of($post->title)->limit(30)}}</a></td>
                            <td>{{$post->category_post->name}}</td>
                            <td>{{$post->user->name}}</td>
                            <td>{{date('d/m/Y', strtotime($post->created_at))}}</td>
                            <td>
                                <a href="{{route('post.edit', $post->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
    
                                <a href="{{route('post.delete',$post->id)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                               
                            </td>
                         </tr>
                            
                        @endforeach
                       
                    </tbody>
                </table>
               
            </div>
    
            @else  
            <tr>
                <td colspan="8"><p >Danh sách không tồn tại!</p></td>
            </tr>
            @endif
            </form>
            
        {{$posts->links()}}
    </div>
</div>
@endsection