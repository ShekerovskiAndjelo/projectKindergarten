<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kindergartens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('street');
            $table->foreignId('managed_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes(); // Adding soft delete functionality
        });
    }

    public function down()
    {
        Schema::dropIfExists('kindergartens');
    }
};
