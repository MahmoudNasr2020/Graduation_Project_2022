<?php

namespace App\Http\Controllers\Api\Dashboard\Company;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiTrait;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
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
        $companies = Company::paginate(150);
        if(!$companies)
        {
            return $this->response('Not Found Data','success',204);
        }
        return $this->response($companies,'success',200);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'company_name'          => ['required','string'],
                'email'                 => ['required','email','unique:companies,email'],
                'phone'                 => ['required','unique:companies,phone'],
                'password'              => ['required','min:8'],
                'registration_number'   => ['required','numeric','unique:companies,registration_number'],
                'registered_address'    => ['required','string'],
                'tax_id'                => ['required','numeric','unique:companies,tax_id'],
                'registration_document' => ['required','image','max:2048'],
                'tax_document'          => ['required','image','max:2048'],
                'image'                 => ['sometimes','nullable','image','max:2048'],
                'status'                => ['sometimes','nullable','in:enable,disable'],
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }

        if($request->status == '')
        {
            $request->merge(['status'=>'disable']);
        }
        if($request->hasFile('image')){
            $image = $this->image('companies',$request->image);
        }
        $registration_document = $this->image('registrations',$request->registration_document);
        $tax_document = $this->image('taxes',$request->tax_document);

        $company = Company::create([
                'company_name'          => $request->company_name,
                'email'                 => $request->email,
                'phone'                 => $request->phone,
                'password'              => Hash::make($request->password),
                'registration_number'   => $request->registration_number,
                'registered_address'    => $request->registered_address,
                'tax_id'                => $request->tax_id,
                'registration_document' => $registration_document,
                'tax_document'          => $tax_document,
                'image'                 => isset($image) ? $image : 'default.png',
                'status'                => $request->status
        ]);

        return $this->response($company,'success',201);
    }


    public function show($id)
    {
        $company = Company::find($id);
        if(!$company)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($company,'success',200);
    }

    public function edit($id)
    {
        $company = Company::find($id);
        if(!$company)
        {
            return $this->response('Not Found This Item','success',404);
        }
        return $this->response($company,'success',200);
    }

    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        if(!$company)
        {
            return $this->response('Not Found This Item','success',404);
        }
        $validator = Validator::make($request->all(),
            [
                'company_name'          => ['required','string'],
                'email'                 => ['required','email','unique:companies,email,'.\request()->route('company')],
                'phone'                 => ['required','unique:companies,phone,'.\request()->route('company')],
                'password'              => ['required','min:8'],
                'registration_number'   => ['required','numeric','unique:companies,registration_number,'.\request()->route('company')],
                'registered_address'    => ['required','string'],
                'tax_id'                => ['required','numeric','unique:companies,tax_id,'.\request()->route('company')],
                'registration_document' => ['sometimes','nullable','image','max:2048'],
                'tax_document'          => ['sometimes','nullable','image','max:2048'],
                'image'                 => ['sometimes','nullable','image','max:2048'],
                'status'                => ['sometimes','nullable','in:enable,disable'],
            ]);

        if($validator->fails())
        {
            return $this->response($validator->errors(),'success',422);
        }
        $data = $request->all();

        if($request->status == '')
        {
            $data['status'] = 'disable';
        }

        if($request->hasFile('image')){
            $this->delete_image('images/'.$company->image);
            $data['image'] = $this->image('companies',$request->file('image'));
        }

        if($request->hasFile('registration_document')){
            $this->delete_image('images/'.$company->registration_document);
            $data['registration_document'] = $this->image('registrations',$request->file('registration_document'));
        }

        if($request->hasFile('tax_document')){
            $this->delete_image('images/'.$company->tax_document);
            $data['tax_document'] = $this->image('taxes',$request->file('tax_document'));
        }

        if($request->has('password'))
        {
            $data['password'] = Hash::make($request->password);
        }
        else
        {
            unset($data['password']);
        }

        $company->update($data);
        return $this->response($company,'success',201);

    }


    public function destroy($id)
    {
        $company = Company::find($id);
        if(!$company)
        {
            return $this->response('Not Found This Item','success',204);
        }
        $this->delete_image('images/'.$company->image);
        $this->delete_image('images/'.$company->registration_document);
        $this->delete_image('images/'.$company->tax_document);
        $company->delete();
        return $this->response('Deleted Successfully','success',200);
    }
}
