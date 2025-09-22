<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique(); // NIK
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();

            // Personal Info
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('marital_status', ['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati']);
            $table->string('religion');
            $table->string('blood_type')->nullable();
            $table->text('address');
            $table->string('postal_code')->nullable();
            $table->string('phone');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_relation');
            $table->string('emergency_contact_phone');

            // Documents
            $table->string('id_card_number'); // KTP
            $table->string('family_card_number'); // KK
            $table->string('npwp_number')->nullable();
            $table->string('bpjs_ketenagakerjaan')->nullable();
            $table->string('bpjs_kesehatan')->nullable();

            // Employment Info
            $table->enum('employment_status', ['tetap', 'kontrak', 'magang', 'honor']);
            $table->date('joining_date'); // TMT Kerja
            $table->date('contract_start')->nullable();
            $table->date('contract_end')->nullable();
            $table->string('education_level'); // S1, D3, SMA, dll
            $table->string('major')->nullable(); // Jurusan
            $table->string('university')->nullable(); // Institusi
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};