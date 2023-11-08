<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->integer('id_alumni', true)->nullable(false);
            $table->integer('id_akun')->nullable(false)->index('id_akun');
            $table->string('nama', 60)->nullable(false);
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable(true);
            $table->string('nomor_telepon', 15)->nullable(true);
            $table->date('tanggal_lahir')->nullable(true);
            $table->text('alamat')->nullable(true);
            $table->text('foto')->nullable(true);

            $table->foreign('id_akun')->on('akun')->references('id_akun')->onDelete('cascade')->onUpdate('cascade');

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
    
};
