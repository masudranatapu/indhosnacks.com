<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller as Controller;

class TestimonialController extends Controller {

    // slider show list
    public function index()
    {
        return view('admin.testimonial.index');
    }

}


