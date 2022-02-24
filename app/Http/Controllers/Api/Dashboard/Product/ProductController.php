<?php /** @noinspection DuplicatedCode */

namespace App\Http\Controllers\Api\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ApiTrait;

    public function __construct()
    {
        $this->middleware('rule:product_show',['only'=>['index','show']]);
        $this->middleware('rule:product_add',['only'=>['store']]);
        $this->middleware('rule:product_edit',['only'=>['edit','update']]);
        $this->middleware('rule:product_delete',['only'=>['delete']]);
    }

    public function index()
    {
        $products = Product::paginate(50);
        if(!$products)
        {
            return $this->response('Not Found Data','success',204);
        }
        return $this->response($products,'success',200);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => ['required','string'],
                'price' => ['required','numeric'],
                'country' => ['required','string'],
                'image' => ['required','image','max:2048'],
                'category_id' =>['required','not_in:0'],
                'description'=> ['nullable']
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }

        $image = $this->image('products',$request->image);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'country' => $request->country,
            'image' => $image,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
        return $this->response($product,'success',201);
    }


    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if(!$product)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($product,'success',200);
    }

    public function edit($id)
    {
        $product = Product::with('category')->find($id);
        if(!$product)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($product,'success',200);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if(!$product)
        {
            return $this->response('Not Found This Item','success',404);
        }
        $validator = Validator::make($request->all(),
            [
                'name' => ['required','string'],
                'price' => ['required','numeric'],
                'country' => ['required','string'],
                'image' => ['nullable','image','max:2048'],
                'category_id' =>['required','not_in:0'],
                'description'=> ['required']
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }
        $data = $request->all();

        if($request->hasFile('image')){
            $this->delete_image('images/'.$product->image);
            $data['image'] = $this->image('products',$request->file('image'));
        }

        $product->update($data);
        return $this->response($product,'success',201);

    }


    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product)
        {
            return $this->response('Not Found This Item','success',204);
        }
        $this->delete_image('images/'.$product->image);
        $product->delete();
        return $this->response('Deleted Successfully','success',200);
    }
}
