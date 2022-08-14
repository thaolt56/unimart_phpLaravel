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
            Chỉnh sửa bài viết blog
        </div>
        <div class="card-body">
            <form action="{{url('admin/post/update',$post->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="name" value="{{$post->title}}">
                    @error('title')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">Chọn ảnh bài viết:</label>
                    <input type="file" class="form-control-file mb-2" id="image" name="image" value="{{asset($post->thumbnail)}}">
                    <img src="{{asset($post->thumbnail)}}" alt="" width="200px" class="img-thumbnail">
                    @error('image')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                  </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{$post->content}}</textarea>
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
                        <option @if($post->cat_id == $k) 
                            {{"selected = 'selected'"}}
                             @endif value="{{$k}}">{{$v}}</option>
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
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="pending" @if( $post->status == 'pending')
                        {{"checked ='checked'"}}
                         @endif>
                        <label class="form-check-label" for="exampleRadios1">
                          Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="public" @if( $post->status == 'public')
                        {{"checked ='checked'"}}
                         @endif>
                        <label class="form-check-label" for="exampleRadios2">
                          Công khai
                        </label>
                    </div>
                </div>



                <button type="submit" name="add_post" value="add" class="btn btn-primary">Chỉnh sửa</button>
            </form>
        </div>
    </div>
</div>
@endsection