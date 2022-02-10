<?php

namespace App\Http\Controllers\Api\Dashboard\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /** @noinspection PhpUndefinedMethodInspection */
    public function index()
    {
        $categories = Category::paginate(50);
        if(!$categories)
        {
            return response()->json([
                'data'      =>  'Not Found Data',
                'message'   =>  'success',
                'status'    =>   204
            ]);
        }
        return response()->json([
            'data'      =>  $categories,
            'message'   =>  'success',
            'status'    =>   200
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
