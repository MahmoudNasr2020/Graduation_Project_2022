<?php

namespace App\Http\Controllers\Api\FrontApp\Cart;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use ApiTrait;
    public function index()
    {
        $carts = Cart::with('product')->where('user_id',Auth::user()->id)->get();
        if(!$carts)
        {
            return $this->response('Not Found Data','success',204);
        }
        return $this->response($carts,'success',200);
    }

    /** @noinspection DuplicatedCode */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'product_id'   => ['required'],
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }

        $cart = Cart::where(['user_id'=>Auth::user()->id,'product_id'=>$request->product_id])->first();
        if($cart)
        {
            $cart->increment('quantity');
            $cart->increment('price',Product::where('id',$request->product_id)->first()->price);
            return $this->response($cart,'success',201);
        }
        else
        {
            $cart = Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'price' => Product::where('id',$request->product_id)->first()->price,
                'quantity' => 1,
                ]);
            return $this->response($cart,'success',201);
        }


    }

    public function update(Request $request, $id)
    {
        $cart = Cart::with('product')->find($id);
        if(!$cart)
        {
            return $this->response('Not Found This Item','success',404);
        }

        $validator = Validator::make($request->all(),
            [
                'quantity'     => ['required']
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }

        $cart->update([
            'quantity' => $request->quantity,
            'price' => $request->quantity * Product::where('id',$cart->product_id)->first()->price ,
        ]);
        return $this->response($cart,'success',201);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if(!$cart)
        {
            return $this->response('Not Found This Item','success',204);
        }
        $cart->delete();
        return $this->response('Deleted Successfully','success',200);
    }


}
