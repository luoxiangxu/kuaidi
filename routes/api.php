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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'topup' => 'API\TopupController',
    'cart' => 'API\AddToCartController',
]);

Route::post('/valid','API\TopupController@valid');
Route::post('/unvalid','API\TopupController@unvalid');
Route::get('/success','API\TopupController@success');
Route::get('/rejected','API\TopupController@rejected');
Route::get('/searchsuccesstopup','API\TopupController@searchSuccessTopup');
Route::get('/searchrejectedtopup','API\TopupController@searchRejectedTopup');
Route::get('/editItem','API\AddToCartController@getEditItem');
Route::get('/getorders','API\AddToCartController@getOrders');
Route::get('/getcredit','API\TopupController@getCredit');
Route::get('/placeorder','API\AddToCartController@placeOrder');
Route::get('/searchuserorder','API\AddToCartController@searchUserOrder');
Route::get('/searchaddtocart','API\AddToCartController@searchAddToCart');
Route::get('/getuserorders','API\AddToCartController@getUserOrders');
Route::get('/getusercredit','API\TopupController@getUserCredit');
Route::post('/makeorder','API\AddToCartController@makeOrder');
Route::post('/rejectOrder','API\AddToCartController@rejectOrder');
Route::get('/arrivedorder','API\AddToCartController@arrivedOrder');
Route::get('/makeorderarrived','API\AddToCartController@makeOrderArrived');
Route::get('/searcharrivedorder','API\AddToCartController@searchArrivedOrder');
Route::get('/profile','API\TopupController@getProfile');
Route::post('/updateprofile','API\TopupController@updateProfile');
Route::get('/usertopup','API\TopupController@userTopup');
Route::post('/getquery','API\AddToCartController@getQuery');
Route::get('/orderrecord','API\AddToCartController@orderRecord');
Route::get('/getuser','API\TopupController@getUser');
Route::get('/searchuser','API\TopupController@searchUser');

