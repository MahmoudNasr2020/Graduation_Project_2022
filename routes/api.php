<?php

use App\Http\Controllers\Api\Dashboard\Category\CategoryController;
use App\Http\Controllers\Api\Dashboard\Login\LoginController;
use App\Http\Controllers\Api\Dashboard\Product\ProductController;
use Illuminate\Support\Facades\Route;


//////////////////////////////////////////////Start Route Dashboard ////////////////////////////////////////////////////////////////

Route::group(['prefix'=>'dashboard'],function (){
    ////////StartCategory/////////////
    Route::resource('categories',CategoryController::class);
    ////////End Category/////////////

    ////////StartCategory/////////////
    Route::resource('products', ProductController::class);
    ////////End Category/////////////

    ////////StartCategory/////////////
    Route::post('login', [LoginController::class,'login']);
    ////////End Category/////////////
});


//////////////////////////////////////////////End Route Dashboard ////////////////////////////////////////////////////////////////
