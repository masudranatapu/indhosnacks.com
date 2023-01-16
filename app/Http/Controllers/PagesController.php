<?php

namespace App\Http\Controllers;
use App\Page;

use Illuminate\Http\Request;
use Str;
use File;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public function index(){

       
        $data=Page::latest()->get();
        return view('admin.page',compact('data'));
    }
    public function savewebpage(Request $request){
 
        $pages=new Page();
    
        $pages->page_title=$request->page_title;
        $pages->page_desc=$request->page_desc;

        if(!is_null($request->file('page_img')))
        {
          $icon_ = $request->file('page_img');
          $base_name = preg_replace('/\..+$/', '', $icon_->getClientOriginalName());
          $base_name = explode(' ', $base_name);
          $base_name = implode('-', $base_name);
          $base_name = Str::lower($base_name);
          $image_name = $base_name."-".uniqid().".".$icon_->getClientOriginalExtension();
          $file_path = 'upload/pages/';
          if (!File::exists($file_path)) {
            File::makeDirectory($file_path, 777, true);
          }
         $icon_->move($file_path, $image_name);
         $pages->page_img  = $image_name;
        //  $icon->icon_image = $file_path.$image_name;
        }
     

        $pages->save();
       
        Session::flash("message",__('successerr.data_save'));
        Session::flash('alert-class', 'alert-success');
       return redirect("setting/5");
  
  
      }
}
