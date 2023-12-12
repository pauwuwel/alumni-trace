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
        Schema::create('logs', function (Blueprint $table) {
            $table->integer('id_logs', true)->nullable(false);
            $table->string('actor', 60)->nullable(false);
            $table->string('action', 60)->nullable(false);
            $table->string('table', 60)->nullable(false);
            $table->string('row', 60)->nullable(false);
            $table->dateTime('date')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
