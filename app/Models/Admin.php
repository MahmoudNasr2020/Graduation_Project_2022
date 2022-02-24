<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'rule_id'
    ];
    protected $hidden = [
        'password',
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class,'rule_id');
    }
}
