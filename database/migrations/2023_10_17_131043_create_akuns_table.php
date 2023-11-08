<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->integer('id_akun', true)->nullable(false);
            $table->string('username', 60)->nullable(false);
            $table->text('password')->nullable(false);
            $table->enum('role', ['superAdmin', 'admin', 'alumni'])->nullable(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
