<?php

namespace App\Http\Controllers\Api\Dashboard\Rule;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use App\Models\Category;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuleController extends Controller
{
    use ApiTrait;

    public function __construct()
    {
        $this->middleware('rule:rule_show',['only'=>['show']]);
        $this->middleware('rule:rule_add',['only'=>['store']]);
        $this->middleware('rule:rule_edit',['only'=>['edit','update']]);
        $this->middleware('rule:rule_delete',['only'=>['delete']]);
    }

    /** @noinspection PhpUnused */
    public function check_value($request)
    {
      $data =   Validator::make($request->all(),[
            'name' => ['required','unique:rules,name,'.\request()->route('id')],
            'rule_show'=>['sometimes','nullable','in:enable,disable'],
            'rule_add'=>['sometimes','nullable','in:enable,disable'],
            'rule_edit'=>['sometimes','nullable','in:enable,disable'],
            'rule_delete'=>['sometimes','nullable','in:enable,disable'],
            'category_show'=>['sometimes','nullable','in:enable,disable'],
            'category_add'=>['sometimes','nullable','in:enable,disable'],
            'category_edit'=>['sometimes','nullable','in:enable,disable'],
            'category_delete'=>['sometimes','nullable','in:enable,disable'],
            'product_show'=>['sometimes','nullable','in:enable,disable'],
            'product_add'=>['sometimes','nullable','in:enable,disable'],
            'product_edit'=>['sometimes','nullable','in:enable,disable'],
            'product_delete'=>['sometimes','nullable','in:enable,disable'],
        ]);
      return $data;
    }

    public function show($id)
    {
        $rule = Rule::find($id);
        if(!$rule)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($rule,'success',200);

    }

    public function store(Request $request)
    {
        $validate = $this->check_value($request);
        if($validate->fails()){
            return $this->response($validate->errors(),'success',422);
        }
        $data = [];
        $data ['name'] = $request->name;
        foreach ($request->all() as $k=>$v)
        {
            if($v == '')
            {
                $data[$k] = 'disable';
            }
            else
            {
                $data[$k] = $v;
            }
        }
        $rule =  Rule::create($data);
        return $this->response($rule,'success',201);
    }

    public function edit($id){

        $rule = Rule::find($id);
        if(!$rule)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($rule,'success',200);
    }

    /** @noinspection DuplicatedCode */
    public function update(Request $request,$id)
    {
        $rule = Rule::find($id);
        if(!$rule)
        {
            return $this->response('Not Found This Item','success',404);
        }

        $validate = $this->check_value($request);
        if($validate->fails()){
            return $this->response($validate->errors(),'success',422);
        }
        $data = [];
        $data ['name'] = $request->name;
        foreach ($request->all() as $k=>$v)
        {
            if($v == '')
            {
                $data[$k] = 'disable';
            }
            else
            {
                $data[$k] = $v;
            }
        }
        $rule->update($data);
        return $this->response($rule,'success',201);
    }

    public function destroy($id)
    {
        $rule = Rule::find($id);
        if(!$rule)
        {
            return $this->response('Not Found This Item','success',204);
        }
        $rule->delete();
        return $this->response('Deleted Successfully','success',200);
    }
}
