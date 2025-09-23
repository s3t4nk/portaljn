<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employee_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('nik'); // FK ke employees.nik
            $table->foreignId('category_id')->nullable()->constrained('certificate_categories')->onDelete('set null');
            $table->string('type'); // nama sertifikat, bisa input manual
            $table->string('number'); // nomor sertifikat
            $table->date('issued_date');
            $table->date('expiry_date');
            $table->string('issuing_authority')->nullable(); // lembaga penerbit
            $table->string('document_path')->nullable(); // path file PDF
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index untuk performa
            $table->index('nik');
            $table->index('expiry_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_certificates');
    }
};