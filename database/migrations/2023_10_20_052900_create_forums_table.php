<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //Membuat tabel forum dengan migration
    public function up(): void
    {
        Schema::create('forum', function (Blueprint $table) {
            $table->integer('id_forum', true)->nullable(false);
            $table->integer('id_pembuat')->nullable(false)->index('id_pembuat');
            $table->string('judul', 60)->nullable(false);
            $table->text('content')->nullable(false);
            $table->text('attachment')->nullable(true);
            $table->enum('status', ['pending', 'accepted', 'rejected'])
                    ->default('pending')->nullable(false);
            $table->date('tanggal_post')->nullable(false);

            $table->foreign('id_pembuat')->on('akun')->references('id_akun')
                    ->onUpdate('cascade')->onDelete('cascade');
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
