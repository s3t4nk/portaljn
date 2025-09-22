<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employee_salary_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('period'); // format: Y-m (misal: 2025-09)
            $table->decimal('base_salary', 12, 2);
            $table->json('components')->nullable(); // [ { "name": "Tunj. Jabatan", "amount": 1500000 } ]
            $table->decimal('total_salary', 12, 2);
            $table->string('status')->default('draft'); // draft, published, paid
            $table->timestamps();

            $table->unique(['employee_id', 'period']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_salary_histories');
    }
};