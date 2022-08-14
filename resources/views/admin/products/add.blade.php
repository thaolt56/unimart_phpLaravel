@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form action="{{url('admin/product/store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Nhập tên sản phẩm" value="{{old('name')}}">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input class="form-control" type="text" name="price" id="price" placeholder="Nhập giá sản phẩm" value="{{old('price')}}">
                            @error('price')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="desc">Mô tả sản phẩm</label>
                            <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">{{old('desc')}}</textarea>
                            @error('desc')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Chọn ảnh sản phẩm:</label>
                    <input type="file" class="form-control-file mb-2" id="image" name="image" value="">
                    @error('image')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                {{-- //bo suu tap anh san pham --}}
                <div class="form-group">
                    <label for="image">Chọn ảnh chi tiết sản phẩm:</label>
                    <input type="file" class="form-control-file mb-2" id="image" name="image_detail[]" value="" multiple>
                    @error('image_detail')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="intro">Chi tiết sản phẩm</label>
                    <textarea name="detail" class="form-control" id="intro" cols="30" rows="5">{{old('detail')}}</textarea>
                    @error('detail')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="category">Danh mục</label>
                    <select class="form-control" id="category" name="category" value="{{old('category')}}">
                        <option value="">Chọn danh mục</option>
                        @if ($data_select)
                            @foreach ($data_select as $k => $v)
                            <option value="{{$k}}">{{$v}}</option>
                            @endforeach
                            
                        @endif
                        {{-- <option>Danh mục 1</option>
                        <option>Danh mục 2</option>
                        <option>Danh mục 3</option>
                        <option>Danh mục 4</option> --}}
                        @error('category')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </select>
                </div>
               <div class="row">
                   <div class="col-4">
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
                        @error('status')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                   </div>
                   <div class="col-4">
                    <div class="form-group">
                        <label for="">Nổi bật</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="highlight" id="exampleRadios1" value="0" >
                            <label class="form-check-label" for="exampleRadios1">
                                Có
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="highlight" id="exampleRadios2" value="1" checked>
                            <label class="form-check-label" for="exampleRadios2">
                                Không
                            </label>
                        </div>
                        @error('highlight')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                   </div>
                   <div class="col-4">
                    <div class="form-group">
                        <label for="">Kho hàng</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="warehouse" id="exampleRadios1" value="1" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Có
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="warehouse" id="exampleRadios2" value="0" >
                            <label class="form-check-label" for="exampleRadios2">
                                Không
                            </label>
                        </div>
                        @error('highlight')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                   </div>
               </div>



                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection