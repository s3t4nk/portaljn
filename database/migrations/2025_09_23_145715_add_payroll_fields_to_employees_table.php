<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->decimal('tunjangan_laut', 12, 2)->nullable()->after('bank_account_number');
            $table->decimal('bpjs_kesehatan_potongan', 12, 2)->nullable()->after('bpjs_kesehatan');
            $table->decimal('bpjs_ketenagakerjaan_potongan', 12, 2)->nullable()->after('bpjs_ketenagakerjaan');
            $table->decimal('pph21_potongan', 12, 2)->nullable()->after('npwp_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
