<?php

namespace App\Http\Controllers\Api\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiTrait;

    /*
      public function __construct()
    {
        $this->middleware('rule:product_show',['only'=>['index','show']]);
        $this->middleware('rule:product_add',['only'=>['store']]);
        $this->middleware('rule:product_edit',['only'=>['edit','update']]);
        $this->middleware('rule:product_delete',['only'=>['delete']]);
    }
    */

    public function index()
    {
        $users = User::paginate(150);
        if(!$users)
        {
            return $this->response('Not Found Data','success',204);
        }
        return $this->response($users,'success',200);
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
                'email' => ['required','email','unique:users,email'],
                'password' => ['required','min:8'],
                'image' => ['required','image','max:2048'],
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }

        $image = $this->image('users',$request->image);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image,
        ]);
        return $this->response($user,'success',201);
    }


    public function show($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($user,'success',200);
    }

    public function edit($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($user,'success',200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->response('Not Found This Item','success',404);
        }
        $validator = Validator::make($request->all(),
            [
                'name' => ['required','string'],
                'email' => ['required','email','unique:users,email,'.\request()->route('user')],
                'password' => ['sometimes','nullable','min:8'],
                'image' => ['sometimes','nullable','image','max:2048'],
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }
        $data = $request->all();

        if($request->hasFile('image')){
            $this->delete_image('images/'.$user->image);
            $data['image'] = $this->image('users',$request->file('image'));
        }

        if($request->has('password'))
        {
            $data['password'] = Hash::make($request->password);
        }
        else
        {
            unset($data['password']);
        }

        $user->update($data);
        return $this->response($user,'success',201);

    }


    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->response('Not Found This Item','success',204);
        }
        $this->delete_image('images/'.$user->image);
        $user->delete();
        return $this->response('Deleted Successfully','success',200);
    }
}
