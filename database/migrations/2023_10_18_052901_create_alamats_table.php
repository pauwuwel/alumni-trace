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
        Schema::create('alamat', function (Blueprint $table) {
            $table->integer('id_alamat', true)->nullable(false);
            $table->integer('id_alumni')->index('id_alumni')->nullable(false);
            $table->string('jalan', 30)->nullable(true);
            $table->string('gang', 30)->nullable(true);
            $table->string('nomor_rumah', 5)->nullable(true);
            $table->string('blok', 5)->nullable(true);
            $table->integer('rt')->nullable(true);
            $table->integer('rw')->nullable(true);
            $table->string('kelurahan', 30)->nullable(true);
            $table->string('kecamatan', 30)->nullable(true);
            $table->string('kota', 30)->nullable(true);
            $table->integer('kodepos')->nullable(true);

            $table->foreign('id_alumni')->on('alumni')->references('id_alumni')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
