<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Ubah kolom yang boleh kosong menjadi NULLABLE
            $table->string('family_card_number')->nullable()->change();
            $table->string('npwp_number')->nullable()->change();
            $table->string('bpjs_ketenagakerjaan')->nullable()->change();
            $table->string('bpjs_kesehatan')->nullable()->change();
            $table->date('contract_start')->nullable()->change();
            $table->date('contract_end')->nullable()->change();
            $table->string('education_level')->nullable()->change();
            $table->string('major')->nullable()->change();
            $table->string('university')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Kembalikan ke NOT NULL (jika perlu)
            $table->string('family_card_number')->nullable(false)->change();
            $table->string('npwp_number')->nullable(false)->change();
            $table->string('bpjs_ketenagakerjaan')->nullable(false)->change();
            $table->string('bpjs_kesehatan')->nullable(false)->change();
            $table->date('contract_start')->nullable(false)->change();
            $table->date('contract_end')->nullable(false)->change();
            $table->string('education_level')->nullable(false)->change();
            $table->string('major')->nullable(false)->change();
            $table->string('university')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
        });
    }
};