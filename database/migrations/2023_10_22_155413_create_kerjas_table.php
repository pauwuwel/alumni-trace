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
        Schema::create('kerja', function (Blueprint $table) {
            $table->integer('id_kerja', true)->nullable(false);
            $table->integer('id_alumni')->index('id_alumni')->nullable(false);
            $table->string('instansi', 60)->nullable(false);
            $table->string('jabatan', 60)->nullable(false);
            $table->date('tanggal_masuk')->nullable(false);
            $table->date('tanggal_keluar')->nullable(true);

            $table->foreign('id_alumni')->on('alumni')->references('id_alumni')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerja');
    }
};
