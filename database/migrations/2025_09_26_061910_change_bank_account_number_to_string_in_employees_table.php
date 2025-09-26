<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Ubah kolom menjadi string (varchar)
            $table->string('bank_account_number', 50)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Kembalikan ke tipe sebelumnya (jika perlu)
            $table->bigInteger('bank_account_number')->nullable()->change();
        });
    }
};