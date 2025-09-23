<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employee_salary_component', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('salary_component_id');
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('salary_component_id')->references('id')->on('salary_components')->onDelete('cascade');

            // Prevent duplicate assignment
            $table->unique(['employee_id', 'salary_component_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_salary_component');
    }
};