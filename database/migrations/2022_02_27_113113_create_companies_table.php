<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->bigInteger('registration_number')->unique();
            $table->string('registered_address');
            $table->bigInteger('tax_id')->unique();
            $table->string('registration_document');
            $table->string('tax_document');
            $table->string('image')->default('default.png');
            $table->enum('status',['enable','disable'])->default('disable');
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
        Schema::dropIfExists('companies');
    }
}
