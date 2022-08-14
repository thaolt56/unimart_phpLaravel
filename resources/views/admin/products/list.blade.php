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
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="text" class="form-control form-search" placeholder="Tìm kiếm" name="keyword" value="{{request()->input('keyword')}}">
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
            <form action="{{route('product.action')}}" method="POST">
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
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Ảnh chi tiết</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Kho hàng</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                @if ($list_products->total()>0)
               
                <tbody>
                    @php
                        $t=0;
                    @endphp
                    @foreach ($list_products as $product)
                    @php
                        $t+=1;
                    @endphp
                    <tr class="">
                        <td>
                            <input type="checkbox" name="list_checkbox[]" value="{{$product->id}}">
                        </td>
                        <td>{{$t}}</td>
                        <td><img width="80px" src="{{asset($product->thumbnail)}}" alt=""></td>
                        <td><a href="#">{{Str::of($product->name)->limit(30)}}</a></td>
                        <td>
                            <a href="{{route('product.images',$product->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Images"><i class="far fa-images"></i></a>
                        </td>
                        <td>{{number_format($product->price,0,'','.')}}VND</td>
                        <td>{{$product->category->name}}</td>
                        <td>{{date('d/m/Y', strtotime($product->created_at))}}</td>
                        <td>
                           @if ($product->warehouse == 1)
                           <span class="badge badge-success">Còn hàng</span>
                           @else
                           <span class="badge bg-secondary">Hết hàng</span>
                           @endif
                        </td>
                        <td>
                            @if($status != 'destroy')
                            <a href="{{route('product.edit',$product->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            @endif
                            <a href="{{route('product.delete',$product->id)}}" onclick="return confirm('Bạn có chắc xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                   
                    
                    
                </tbody>
                @else
                <tr>
                    <td colspan="8"><p >Danh sách không tồn tại!</p></td>
                </tr>
                @endif
               
            </table>
        </form>
            {{$list_products->links()}}
        </div>
    </div>
</div>
@endsection