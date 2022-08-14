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
            Thêm bài viết blog
        </div>
        <div class="card-body">
            <form action="{{url('admin/post/store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="name" value="{{old('title')}}">
                    @error('title')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">Chọn ảnh bài viết:</label>
                    <input type="file" class="form-control-file mb-2" id="image" name="image" value="{{old('image')}}">
                    {{-- <img src="{{asset('vendor\laravel-filemanager\img\152px color.png')}}" alt="" width="200px" class="img-thumbnail"> --}}
                    @error('image')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                  </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{old('content')}}</textarea>
                    @error('content')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="" name="category">
                      <option value="">Chọn danh mục</option>
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
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="pending" checked>
                        <label class="form-check-label" for="exampleRadios1">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="public">
                        <label class="form-check-label" for="exampleRadios2">
                          Công khai
                        </label>
                    </div>
                </div>



                <button type="submit" name="add_post" value="add" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection