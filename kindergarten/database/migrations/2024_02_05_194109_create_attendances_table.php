<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kid_id')->constrained('kids');
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('kindergarten_id')->constrained('kindergartens');
            $table->date('date');
            $table->tinyInteger('status')->default(0); // Assuming status is boolean (0/1)
            $table->timestamps();
            $table->softDeletes(); // Adding soft delete functionality
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
