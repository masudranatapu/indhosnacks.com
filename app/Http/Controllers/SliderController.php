<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller as Controller;

class SliderController extends Controller {

    public function index()
    {
        return view('admin.slider.index');
    }
}


