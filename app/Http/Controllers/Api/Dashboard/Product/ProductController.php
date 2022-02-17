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
                'name' => ['required','unique:products,name','string'],
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
