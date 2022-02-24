<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;
    protected $fillable = ['name','rule_show','rule_add', 'rule_edit', 'rule_delete', 'category_show', 'category_add',
                            'category_edit', 'category_delete', 'product_show', 'product_add', 'product_edit',
                            'product_delete','admin_show', 'admin_add', 'admin_edit', 'admin_delete', ];

}
