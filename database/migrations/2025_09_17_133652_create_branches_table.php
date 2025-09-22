<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama cabang/kapal/kantor
            $table->enum('type', ['pusat', 'cabang', 'kapal']); // Tipe lokasi
            $table->string('kelas')->nullable(); // A, B, C (untuk cabang & kapal)
            $table->text('address')->nullable(); // Alamat atau rute operasi
            $table->string('phone')->nullable(); // Kontak
            $table->decimal('latitude', 10, 8)->nullable(); // Untuk absensi GPS
            $table->decimal('longitude', 11, 8)->nullable(); // Untuk absensi GPS
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('branches');
    }
};