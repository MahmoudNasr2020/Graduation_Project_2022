<?php

use App\Http\Controllers\Api\Dashboard\Category\CategoryController;
use App\Http\Controllers\Api\Dashboard\Product\ProductController;
use Illuminate\Support\Facades\Route;


//////////////////////////////////////////////Start Route Dashboard ////////////////////////////////////////////////////////////////
///
    ////////StartCategory/////////////
    Route::resource('categories',CategoryController::class);
    ////////End Category/////////////

    ////////StartCategory/////////////
    Route::resource('products', ProductController::class);
    ////////End Category/////////////
    ///
//////////////////////////////////////////////End Route Dashboard ////////////////////////////////////////////////////////////////
