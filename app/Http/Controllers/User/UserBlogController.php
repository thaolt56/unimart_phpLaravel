<?php

namespace App\Http\Controllers\User;
use App\post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserBlogController extends Controller
{   
   
    function index(){

        $posts = post::latest()->paginate(5);
        return view('user.blog.index',compact('posts'));
    }

    function detail(Request $request){
        // return $request->slug;
        $id = $request->id;
      
       $post_detail = post::find($id);
       
       return view('user.blog.detail',compact('post_detail'));
    }
}
