<?php

namespace App\Http\Controllers\Api\Dashboard\Category;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiTrait;

    public function __construct()
    {
         $this->middleware('rule:category_show',['only'=>['index','show']]);
         $this->middleware('rule:category_add',['only'=>['store']]);
         $this->middleware('rule:category_edit',['only'=>['edit','update']]);
         $this->middleware('rule:category_delete',['only'=>['delete']]);
    }

    /** @noinspection PhpUndefinedMethodInspection */
    public function index()
    {
        $categories = Category::paginate(150);
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

    /** @noinspection DuplicatedCode */
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
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($category,'success',200);

    }

    public function edit($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($category,'success',200);
    }

    /** @noinspection DuplicatedCode */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return $this->response('Not Found This Item','success',404);
        }

        $validator = Validator::make($request->all(),
            [
                'name' => ['required','unique:categories,name,'.$id,'string'],
                'description'=> ['nullable']
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return $this->response($category,'success',201);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return $this->response('Not Found This Item','success',204);
        }
        $category->products()->delete();
        $category->delete();
        return $this->response('Deleted Successfully','success',200);
    }
}
