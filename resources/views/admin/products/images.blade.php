
@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    @if (session('status'))
    <div class="alert alert-primary" role="alert">
        {{session('status')}}
    </div>
    @endif
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm ảnh chi tiết sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{route('images.add',$product_id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">Thêm ảnh sản phẩm:</label>
                            <input type="file" class="form-control-file mb-2" id="image" name="image" value="">
                            @error('image')
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
                       <button type="submit" class="btn btn-primary">Thêm mới ảnh</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục ảnh chi tiết
                </div>
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{request()->fullUrlWithQuery(['status'=>'full'])}}" class="text-primary">Tất cả<span class="text-muted">({{$count[0]}})</span></a>
                        <a href="{{request()->fullUrlWithQuery(['status'=>'public'])}}" class="text-primary">Công khai<span class="text-muted">({{$count[1]}})</span></a>
                        <a href="{{request()->fullUrlWithQuery(['status'=>'pending'])}}" class="text-primary">Chờ duyệt<span class="text-muted">({{$count[2]}})</span></a>
                        <a href="{{request()->fullUrlWithQuery(['status'=>'destroy'])}}" class="text-primary">Xóa tạm thời<span class="text-muted">({{$count[3]}})</span></a>
                    </div>
                    <form action="{{route('image.list_action',$product_id)}}" method="POST">
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
                    <table class="table table-striped  table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Tên thư mục</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        @if ($images->total()>0)
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($images as $image)
                            @php
                                $t+=1;
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" name="list_checkbox[]" value="{{$image->id}}">
                                </td>
                                <td>{{$t}}</td>
                                <td>{{$image->product_images}}</td>
                                <td>
                                    <img width="120px" src="{{asset($image->product_images)}}" alt="">
                                </td>
                                <td>
                                    {{-- <a href="" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a> --}}
                                    <a href="{{route('images.delete',$image->id)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                   
                                </td>
                            </tr>
                            @endforeach
                           
                           
                        </tbody>
                    </table>
                    @else  
                   
                    <tr>
                        <td colspan="8"><p>Không tồn tại ảnh sản phẩm!</p></td>
                    </tr>
                    
                    @endif
                    {{$images->links()}}
                </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection