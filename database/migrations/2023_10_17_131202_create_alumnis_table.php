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
        Schema::create('alumni', function (Blueprint $table) {
            $table->integer('id_alumni', true)->nullable(false); // tipe data id_alumni
            $table->integer('id_akun')->nullable(false)->index('id_akun'); // tipe data id_akun (fk)
            $table->string('nama', 60)->nullable(false); // tipe data nama
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable(true); // tipe data jenis_kelamin
            $table->string('nomor_telepon', 15)->nullable(true); // tipe data nomor_telepon
            $table->date('tanggal_lahir')->nullable(true); // tipe data tanggal_lahir
            $table->text('foto')->nullable(true); // tipe data foto
            
            $table->foreign('id_akun')->on('akun')->references('id_akun')->onDelete('cascade')->onUpdate('cascade'); // menyambungkan forgein key ke tabel akun

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
