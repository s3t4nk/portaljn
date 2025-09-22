<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama jabatan
            $table->foreignId('salary_grade_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['struktural', 'fungsional', 'operasional'])->default('struktural');
            $table->enum('employee_type', ['darat', 'laut', 'semua'])->default('semua');
            $table->integer('min_experience_years')->default(0);
            $table->json('required_certifications')->nullable(); // untuk pelaut
            $table->string('code', 20)->unique(); // kode unik: BM-A, NAKHODA, dll
            $table->text('description')->nullable();
            $table->boolean('is_management')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
};