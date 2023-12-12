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
        Schema::create('komentar', function (Blueprint $table) {
            $table->integer('id_komentar', true)->nullable(false);
            $table->integer('id_forum')->index('id_forum')->nullable(false);
            $table->integer('id_pembuat')->index('id_pembuat')->nullable(false);
            $table->integer('deletedBy')->index('deletedBy')->nullable(true);
            $table->text('komentar')->nullable(false);
            $table->text('attachment')->nullable(true);
            $table->dateTime('tanggal_post')->nullable(false);

            $table->foreign('id_forum')->on('forum')->references('id_forum')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_pembuat')->on('akun')->references('id_akun')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('deletedBy')->on('akun')->references('id_akun')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};
