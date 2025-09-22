<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('salary_grades', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('grade');           // I s/d VII
            $table->char('class', 1);               // A, B, C
            $table->tinyInteger('subclass');        // 1, 2, 3
            $table->string('code', 10)->unique();   // misal: VII-C1
            $table->decimal('base_salary', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_grades');
    }
};