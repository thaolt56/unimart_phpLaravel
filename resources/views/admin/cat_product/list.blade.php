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
                    Danh mục sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{url('admin/product/cat/store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category">Danh mục cha</label>
                            <select class="form-control" id="category" name="category" >
                                <option value="0">Chọn danh mục</option>
                                @if($data_select)
                                    @foreach ($data_select as $k=>$v)
                                    <option value="{{$k}}">{{$v}}</option>
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
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách danh mục sản phẩm
                </div>
                <div class="card-body">
                  
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên danh mục</th>
                                {{-- <th scope="col">slug</th> --}}
                               
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($data_select as $k=>$v)
                            @php
                                $t+=1;
                            @endphp
                            <tr>
                                <td>{{$t}}</td>
                                <td>{{$v}}</td>
                                {{-- <td>{{$cat->slug}}</td> --}}
                                {{-- <td>@foreach ($cat_product as $item)
                                    @if ($cat->parent_id == $item->id)
                                        {{$item->name}}
                                       
                                    @endif
                                @endforeach</td> --}}
                                <td>
                                    <a href="{{route('cat_product.edit',$k)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
    
                                    <a href="{{route('cat_product.delete',$k)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr> 
                            @endforeach
                           
                         
                        </tbody>
                    </table>
                </div>
               
                        
             
                    
            </div>
        </div>
    </div>

</div>
@endsection