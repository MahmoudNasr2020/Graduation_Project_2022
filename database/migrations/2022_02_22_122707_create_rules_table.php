<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('rule_show',['enable','disable'])->default('disable');
            $table->enum('rule_add',['enable','disable'])->default('disable');
            $table->enum('rule_edit',['enable','disable'])->default('disable');
            $table->enum('rule_delete',['enable','disable'])->default('disable');
            $table->enum('category_show',['enable','disable'])->default('disable');
            $table->enum('category_add',['enable','disable'])->default('disable');
            $table->enum('category_edit',['enable','disable'])->default('disable');
            $table->enum('category_delete',['enable','disable'])->default('disable');
            $table->enum('product_show',['enable','disable'])->default('disable');
            $table->enum('product_add',['enable','disable'])->default('disable');
            $table->enum('product_edit',['enable','disable'])->default('disable');
            $table->enum('product_delete',['enable','disable'])->default('disable');
            $table->enum('admin_show',['enable','disable'])->default('disable');
            $table->enum('admin_add',['enable','disable'])->default('disable');
            $table->enum('admin_edit',['enable','disable'])->default('disable');
            $table->enum('admin_delete',['enable','disable'])->default('disable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
}
