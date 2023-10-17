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
        Schema::create('akun', function (Blueprint $table) {
            $table->integer('id_akun', true)->nullable(false); // menentukan tipe data id_akun
            $table->string('username', 60)->nullable(false); // menentukan tipe data username
            $table->text('password')->nullable(false); // menentukan tipe data password
            // $table->string('email', 225)->nullable(false); // menentukan tipe data email
            $table->enum('role', ['superAdmin', 'admin', 'alumni'])->nullable(false); // menentukan tipe data email
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun');
    }
};
