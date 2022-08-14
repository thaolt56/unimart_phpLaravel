@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm trang
        </div>
        <div class="card-body">
            <form action="{{route('page.add')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tiêu đề trang</label>
                    <input class="form-control" type="text" name="title" id="name" value="{{old('title')}}">
                    @error('title')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung trang</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{old('content')}}</textarea>
                    @error('content')
                    <small class="text-danger">{{$message}}</small>
                @enderror
                </div>



                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection