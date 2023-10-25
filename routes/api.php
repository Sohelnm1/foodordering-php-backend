<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FoodItemsController;
use App\Http\Controllers\FoodPriceQuantityController;
use App\Http\Controllers\CategoryStore;
use App\Http\Controllers\FoodItemStore;
use App\Http\Controllers\FoodPriceStore;
use App\Http\Controllers\FoodItemCategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//  Display all catergories list 
Route::get("/categories",[CategoriesController::class,'display']);

//  Display all fooditems list 
Route::get("/foods",[FoodItemsController::class,'getall']);

//  Display all foodprice list 
Route::get("/foodprice",[FoodPriceQuantityController::class,'getall']);

//  Store new category
Route::post('/categoriestore',[CategoryStore::class,'store']);

//  Store new fooditems
Route::post('/fooditems',[FoodItemStore::class,'foodstore']);

//  Store new fooditem price
Route::post('/foodprice',[FoodPriceStore::class,'store']);


// Display all food with their category and price 
Route::get("/getfood", [FoodItemsController::class,'foodwithcatergoryprice']);

Route::post('/auth/login',[AuthController::class,'login']);

Route::post('/auth/register',[AuthController::class,'register']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout',[AuthController::class,'logout']);

    // get category by name 
    Route::post("/catergorybyname/{name}",[CategoriesController::class, 'categoryname']);

    //  Getting data by id category food and price
    Route::get("/categorybyid",[CategoriesController::class,'bycategory']);

    //  delete catergory setting status 1
    Route::get("/deletecategory",[CategoriesController::class,'deletecategory']);

    //  Update category by id
    Route::put("/updatecategory/{id}",[CategoriesController::class,'updatecategory']);

    // Update fooditem 
    Route::put('/updatefooditem/{id}', [FoodItemsController::class, 'updatefood']);

    // Delete fooditem
    Route::get("/deletefooditem", [FoodItemsController::class,'deletefood']);

    //  Update Food item
    Route::put('/updateprice/{id}', [FoodPriceQuantityController::class, 'updateprice']);

    // Delete foodprice
    Route::get("/foodpricedelete", [FoodPriceQuantityController::class,'deleteprice']);

    // New Address store
    Route::post('/useraddress', [AddressController::class,"newaddress"]);

    // New address by user 
    Route::post('/user/{name}/newaddress', [AddressController::class,"adduseraddress"]);

    // list address of users
    Route::get('/getuseraddress/{name}',[AddressController::class,"useraddress"]);

    // get all address of each users
    Route::get('/alladdress',[AddressController::class,"getalladdress"]);

    // Update address
    Route::put('/update/{id}',[AddressController::class,"update"]);

    // Update address by username 
    Route::put('/user/{name}/address/{addressname}',[AddressController::class,"updateByname"]);

    // set status to 1 delete
    Route::post('/delete/address/{id}', [AddressController::class, "deleteaddress"]);

    // set status to 1 delete
    Route::post('/user/{name}/deleteaddress/{addressname}', [AddressController::class, "userdeleteaddress"]);


    // store orders random
    Route::post('/order', [OrderController::class, "orderstore"]);

    // create order by user
    Route::post('/user/{user}/order/{orderitem}', [OrderController::class, "createuserorder"]);

    // read user orders 
    Route::get('/order/{name}', [OrderController::class, "userorder"]);

    // read all orders 
    Route::get('/order', [OrderController::class, "orderall"]);

    // delete orders
    // Route::post('/order', [OrderController::class, "deleteall"]);

    // delete user orders
    Route::post('/user/{name}/orderdelete/{order}', [OrderController::class, "userdelete"]);

});