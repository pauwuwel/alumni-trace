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
        Schema::create('karir', function (Blueprint $table) {
            $table->integer('id_karir', true)->nullable(false);
            $table->integer('id_alumni')->index('id_alumni')->nullable(false);
            $table->enum('jenis_karir', ['kuliah', 'kerja', 'wirausaha']);
            $table->string('nama_instansi', 60)->nullable(false);
            $table->string('posisi_bidang', 60)->nullable(false);
            $table->date('tanggal_mulai')->nullable(false);
            $table->date('tanggal_selesai')->nullable(true);

            $table->foreign('id_alumni')->on('alumni')->references('id_alumni')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karir');
    }
};
