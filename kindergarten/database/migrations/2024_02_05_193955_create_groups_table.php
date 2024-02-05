<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('period');
            $table->foreignId('kindergarten_id')->constrained('kindergartens');
            $table->foreignId('teacher_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes(); // Adding soft delete functionality
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
