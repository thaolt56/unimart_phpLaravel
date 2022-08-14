@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="alert alert-primary" role="alert">
        {{session('status')}}
    </div>
    @endif
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm danh mục blog
                </div>
                <div class="card-body">
                    <form action="{{url('admin/post/cat/store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" id="" name="category">
                                <option value="0">Chọn danh mục</option>
                                
                                @if ($data_select)
                                    @foreach ($data_select as $k=>$v)
                                    <option value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                @endif
                            </select>

                            @error('category')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="pending" value="pending" checked>
                                <label class="form-check-label" for="pending">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="public" value="public">
                                <label class="form-check-label" for="public">
                                    Công khai
                                </label>
                            </div>
                            @error('status')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div> --}}



                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục bài viết
                </div>
                <div class="card-body">
                    @if ($data_select)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">slug</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category as $item)
                            <tr>
                                <td>{{$item->parent_id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->slug}}</td>
                                <td>
                                    {{-- <a href="" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> --}}
                                    <a href="{{route('post_cat.delete',$item->id)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                   
                                </td>
                            </tr>
                            @endforeach
                           
                           
                        </tbody>
                    </table>
                    @else  
                    <td><p>Danh sách không tồn tại danh mục!</p></td>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>

</div>
@endsection