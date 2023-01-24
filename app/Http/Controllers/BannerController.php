<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller as Controller;

class BannerController extends Controller {

    // slider show list
    public function index()
    {
        return view('admin.banner.index');
    }

}


