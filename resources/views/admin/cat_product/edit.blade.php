@extends('layouts.admin')
@section('content')
<div class="row mt-4 ml-4">
    <div class="col-6" >
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa Danh mục sản phẩm
            </div>
            <div class="card-body">
                <form action="{{url('admin/product/cat/update', $cat->id)}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên danh mục</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{$cat->name}}">
                        @error('name')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category">Danh mục cha</label>
                        <select class="form-control" id="category" name="category" >
                            <option value="0">Danh mục cha</option>
                            @if($data_select)
                                @foreach ($data_select as $k=>$v)
                                <option @if ($cat->parent_id == $k)
                                   {{"selected = 'selected'"}} 
                                @endif value="{{$k}}">{{$v}}</option>
                                @endforeach
                            @endif
                            {{-- <option>Danh mục 1</option>
                            <option>Danh mục 2</option>
                            <option>Danh mục 3</option>
                            <option>Danh mục 4</option> --}}
                        </select>
                        @error('category')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                    </div> --}}



                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection