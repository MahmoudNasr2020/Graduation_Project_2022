<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    use ApiTrait;

    public function __construct()
    {
        $this->middleware('rule:admin_show',['only'=>['index','show']]);
        $this->middleware('rule:admin_add',['only'=>['store']]);
        $this->middleware('rule:admin_edit',['only'=>['edit','update']]);
        $this->middleware('rule:admin_delete',['only'=>['delete']]);
    }

    public function index()
    {
        $admin = Admin::paginate(50);
        if(!$admin)
        {
            return $this->response('Not Found Data','success',204);
        }
        return $this->response($admin,'success',200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => ['required','string'],
                'email' => ['required','email','unique:admins,email'],
                'password' => ['required'],
                'image' => ['required','image','max:2048'],
                'rule_id' =>['required','not_in:0'],
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }

        $image = $this->image('admins',$request->image);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image,
            'rule_id' => $request->rule_id,
        ]);
        return $this->response($admin,'success',201);
    }

    public function show($id)
    {
        $admin = Admin::with('rule')->find($id);
        if(!$admin)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($admin,'success',200);
    }

    public function edit($id)
    {
        $admin = Admin::with('rule')->find($id);
        if(!$admin)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($admin,'success',200);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        if(!$admin)
        {
            return $this->response('Not Found This Item','success',404);
        }
        $validator = Validator::make($request->all(),
            [
                'name' => ['required','string'],
                'email' => ['required','email','unique:admins,email,'.\request()->route('admin')],
                'password' => ['nullable'],
                'image' => ['required','image','max:2048'],
                'rule_id' =>['required','not_in:0'],
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }
        $data = $request->all();

        if($request->hasFile('image')){
            $this->delete_image('images/'.$admin->image);
            $data['image'] = $this->image('admins',$request->file('image'));
        }

        if($request->has('password'))
        {
            $data['password'] = Hash::make($request->password);
        }
        else
        {
            unset($data['password']);
        }

        $admin->update($data);
        return $this->response($admin,'success',201);

    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if(!$admin)
        {
            return $this->response('Not Found This Item','success',204);
        }
        $this->delete_image('images/'.$admin->image);
        $admin->delete();
        return $this->response('Deleted Successfully','success',200);
    }

}
