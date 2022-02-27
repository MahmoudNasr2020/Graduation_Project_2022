<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['company_name','registration_number','registered_address','email','password','phone',
                            'tax_id','registration_document','tax_document','image','status'];


    protected  $hidden = ['password'];
}
