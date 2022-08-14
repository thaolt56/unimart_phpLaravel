@extends('layouts.user')
@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
@endsection
@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Blog</h3>
                </div>
                
                <div class="section-detail">
                    @if ($posts->total()>0)                 
                    <ul class="list-item">
                        @foreach ($posts as $post)
                        <li class="clearfix">
                            <a href="{{route('blog.detail',['id'=>$post->id,'slug'=>Str::slug($post->title)])}}" title="" class="thumb fl-left">
                                <img width="250px" src="{{asset($post->thumbnail)}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{route('blog.detail',['id'=>$post->id,'slug'=>Str::slug($post->title)])}}" title="" class="title">{{$post->title}}</a>
                                <span class="create-date">{{date('d/m/Y', strtotime($post->created_at))}}</span>
                                <p class="desc">
                                    The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                                </p>
                            </div>
                        </li>
                        @endforeach
                       
                      
                    </ul>
                    @else
                    <div class="alert alert-danger" role="alert">
                        <p>Không tồn tại bài viết!</p>
                      </div>
                    @endif
                  
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    {{$posts->links()}}
                </div>
            </div>
            
        </div>
        @include('user.component.sidebar')
    </div>
</div>
@endsection