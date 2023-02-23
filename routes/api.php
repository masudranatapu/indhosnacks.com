<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('locale/{locale}', function (Request $locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any("register","API\ApiController@postregister");//register
Route::any("tokan_data","API\ApiController@savetoken");//store token
Route::any("getcity","API\ApiController@getcity");//get city list
Route::any("deliveryboy_login","API\ApiController@deliveryboy_login");//delivery login
Route::any("deliveryboy_order","API\ApiController@deliveryboy_order");//delivery order
Route::post("deliveryboy_presence","API\ApiController@deliveryboy_presence");
Route::any("deliveryboy_profile","API\ApiController@deliveryboy_profile");

Route::any("ingredients","API\ApiController@ingredients");
Route::any("menu_category","API\ApiController@menucategory");
Route::any("noOfOrder","API\ApiController@noOfOrder");
Route::any("orderdetails","API\ApiController@orderdetails");
Route::any("subcategory","API\ApiController@subcategory");
Route::any("order_history","API\ApiController@order_history");
Route::any("order_cancel","API\ApiController@order_cancel");
Route::any("order_complete","API\ApiController@order_complete");
Route::any("order_pick","API\ApiController@order_pick");
Route::any("order_item_details","API\ApiController@order_item_details");
Route::post("food_order","API\ApiController@food_order");
Route::any("order_details","API\ApiController@order_details");
Route::any("forgotpassword","API\ApiController@forgotpassword");
Route::get("getsetting",'API\ApiController@getsetting');




