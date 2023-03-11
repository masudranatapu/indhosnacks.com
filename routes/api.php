<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AbcController;
use App\Http\Controllers\API\Apiv1Controller;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Session;

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

Route::get('locale/{locale}', function (Request $locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::any("register", "API\Apiv1Controller@postregister"); //register
Route::any("tokan_data", "API\Apiv1Controller@savetoken"); //store token
Route::any("getcity", "API\Apiv1Controller@getcity"); //get city list
Route::any("deliveryboy_login", "API\Apiv1Controller@deliveryboy_login"); //delivery login
Route::any("deliveryboy_order", "API\Apiv1Controller@deliveryboy_order"); //delivery order
Route::post("deliveryboy_presence", "API\Apiv1Controller@deliveryboy_presence");
Route::any("deliveryboy_profile", "API\Apiv1Controller@deliveryboy_profile");

Route::any("ingredients", "API\Apiv1Controller@ingredients");
Route::any("spacial_offer", "API\Apiv1Controller@spacialOffer");
Route::any("popular", "API\Apiv1Controller@popular");
Route::any("testimonial", "API\Apiv1Controller@testimonial");
Route::any("shop", "API\Apiv1Controller@shop");
Route::any("contactInfo", "API\Apiv1Controller@contactInfo");
Route::post("contactSubmit", "API\Apiv1Controller@contactSubmit");
Route::any("menu_category", [Apiv1Controller::class, 'menucategory']);
Route::any("noOfOrder", "API\Apiv1Controller@noOfOrder");
Route::any("orderdetails", "API\Apiv1Controller@orderdetails");
Route::any("viewitem/{id}", "API\Apiv1Controller@viewitem");
Route::any("gettopping", "API\Apiv1Controller@gettopping");
Route::any("subcategory", "API\Apiv1Controller@subcategory");
Route::any("order_history", "API\Apiv1Controller@order_history");
Route::any("order_cancel", "API\Apiv1Controller@order_cancel");
Route::any("order_complete", "API\Apiv1Controller@order_complete");
Route::any("order_pick", "API\Apiv1Controller@order_pick");
Route::any("order_item_details", "API\Apiv1Controller@order_item_details");
Route::post("food_order", "API\Apiv1Controller@food_order");
Route::any("order_details", "API\Apiv1Controller@order_details");
Route::any("forgotpassword", "API\Apiv1Controller@forgotpassword");
Route::get("getsetting", 'API\Apiv1Controller@getsetting');
Route::get("test100", 'API\AbcController@index');




// Route::get('/greeting', [Apiv1Controller::class, 'menucategory']);
