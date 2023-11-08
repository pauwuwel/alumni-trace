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
            $table->integer('id_komentar', true)->nullable(false); // tipe data id_komentar
            $table->integer('id_forum')->index('id_forum')->nullable(false); // tipe data id_forum
            $table->integer('id_pembuat')->index('id_pembuat')->nullable(false); // tipe data id_pembuat
            $table->text('komentar')->nullable(false); // tipe data komentar
            $table->text('attachment')->nullable(true); // tipe data attachment
            $table->date('tanggal_post')->nullable(false); // tipe data tanggal_post

            $table->foreign('id_forum')->on('forum')->references('id_forum')
                  ->onUpdate('cascade')->onDelete('cascade'); // menyambungkan foreign key ke tabel forum
            $table->foreign('id_pembuat')->on('akun')->references('id_akun')
                  ->onUpdate('cascade')->onDelete('cascade'); // menyambungkan foreign key ke tabel akun
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};
