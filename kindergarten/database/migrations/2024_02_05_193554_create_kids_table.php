<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kids', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->foreignId('generated_number_id')->constrained('generated_numbers');
            $table->foreignId('parent_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes(); // Adding soft delete functionality
        });
    }

    public function down()
    {
        Schema::dropIfExists('kids');
    }
};
