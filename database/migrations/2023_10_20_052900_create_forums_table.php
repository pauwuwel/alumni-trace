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
        Schema::create('forum', function (Blueprint $table) {
            $table->integer('id_forum', true)->nullable(false); // tipe data id_forum
            $table->integer('id_pembuat')->nullable(false)->index('id_pembuat'); // tipe data id_pembuat
            $table->string('judul', 60)->nullable(false); // tipe data judul
            $table->text('content')->nullable(false); // tipe data content
            $table->text('attachment')->nullable(true); // tipe data attachment
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->nullable(false); // tipe data status
            $table->date('tanggal_post')->nullable(false); // tipe data tanggal_post

            $table->foreign('id_pembuat')->on('akun')->references('id_akun')->onUpdate('cascade')->onDelete('cascade'); // menyambungkan forgein key ke tabel akun
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum');
    }
};
