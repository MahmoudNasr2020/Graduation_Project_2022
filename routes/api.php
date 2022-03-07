<?php

use App\Http\Controllers\Api\Dashboard\Admin\AdminController;
use App\Http\Controllers\Api\Dashboard\Category\CategoryController;
use App\Http\Controllers\Api\Dashboard\Company\CompanyController;
use App\Http\Controllers\Api\Dashboard\Login\LoginController;
use App\Http\Controllers\Api\Dashboard\Product\ProductController;
use App\Http\Controllers\Api\FrontApp\Cart\CartController;
use App\Http\Controllers\Api\Dashboard\Rule\RuleController;
use App\Http\Controllers\Api\Dashboard\User\UserController;
use Illuminate\Support\Facades\Route;


//////////////////////////////////////////////Start Route Dashboard ////////////////////////////////////////////////////////////////

Route::group(['prefix'=>'dashboard','as'=>'dashboard.'],function (){

    ////////Start login/////////////
    Route::post('login', [LoginController::class,'login']);
    Route::get('unauthenticated',[LoginController::class,'unauthenticated'])->name('unauthenticated');
    ////////End login/////////////

    Route::group(['middleware'=>'auth:api-admin'],function (){

        ////////Start Admin/////////////
        Route::resource('admins',AdminController::class);
        ////////End Admin/////////////


        ////////Start Users/////////////
        Route::resource('users', UserController::class);
        ////////End Users/////////////


        ////////Start Users/////////////
        Route::resource('companies', CompanyController::class);
        ////////End Users/////////////


        ////////Start Category/////////////
        Route::resource('categories',CategoryController::class);
        ////////End Category/////////////


        ////////Start Product/////////////
        Route::resource('products', ProductController::class);
        ////////End Product//////////////


        ////////Start Cart/////////////
        Route::resource('carts', CartController::class);
        ////////End Cart//////////////

        //////// Start Rule /////////////
        Route::get('rule/show/{id}', [RuleController::class,'show']);
        Route::post('rule/store', [RuleController::class,'store']);
        Route::get('rule/edit/{id}', [RuleController::class,'edit']);
        Route::put('rule/update/{id}', [RuleController::class,'update']);
        Route::delete('rule/destroy/{id}', [RuleController::class,'destroy']);
        //////// End Rule /////////////


        ///////Start Logout/////////////
        Route::post('logout', [LoginController::class,'logout']);
        ////////End Logout/////////////

    });

});


//////////////////////////////////////////////End Route Dashboard ////////////////////////////////////////////////////////////////
