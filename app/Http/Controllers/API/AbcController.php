<?php
namespace App\Http\Controllers\API;

use DB;
use Auth;
use App\Setting;
use App\Category;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbcController extends Controller
{


    public function index(Request $request)
    {

        $getsetting=Setting::find(1);
        $getdata=Category::where("is_deleted",'0')->get();
        $response=array('menu_category' =>$getdata,"delivery_charges"=>$getsetting->delivery_charges);
        return Response::json($response);

    }


}
