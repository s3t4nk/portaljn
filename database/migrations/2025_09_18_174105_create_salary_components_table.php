<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('salary_components', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tunjangan Jabatan, Pendidikan, Mobilitas, Komunikasi
            $table->string('type'); // fixed, percentage, dynamic
            $table->decimal('amount', 12, 2); // nominal atau persentase
            $table->string('applicable_to'); // grade, position, employee_type
            $table->unsignedTinyInteger('min_grade')->nullable(); // berlaku mulai grade berapa
            $table->unsignedTinyInteger('max_grade')->nullable(); // maksimal grade
            $table->foreignId('position_id')->nullable()->constrained('positions')->onDelete('set null');
            $table->enum('employee_type', ['darat', 'laut', 'semua'])->nullable(); // jika berdasarkan tipe pegawai
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_components');
    }
};