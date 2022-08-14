<?php

namespace App\Http\Controllers\User;
use App\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPageController extends Controller
{
   function page(Request $request){
       $slug = $request->slug;
    //   return $slug;
      if($slug == 'lien-he'){
          $page = Page::where('slug',$slug)->first();
      }
      else if($slug == 'gioi-thieu'){
          $page = Page::where('slug',$slug)->first();
      }
      
       return view('user.page.page',compact('page'));
   
}
}