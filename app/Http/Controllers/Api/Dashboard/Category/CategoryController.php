<?php

namespace App\Http\Controllers\Api\Dashboard\Category;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponse;

    /** @noinspection PhpUndefinedMethodInspection */
    public function index()
    {
        $categories = Category::paginate(50);
        if(!$categories)
        {
            return $this->response('Not Found Data','success',204);
        }
        return $this->response($categories,'success',200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => ['required','unique:categories,name','string'],
            'description'=> ['nullable']
        ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return $this->response($category,'success',201);

    }

    public function show($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return $this->response('Not Found This Item','success',204);
        }
        return $this->response($category,'success',200);

    }

    public function edit($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return $this->response('Not Found This Item','success',204);
        }
        return $this->response($category,'success',200);
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
