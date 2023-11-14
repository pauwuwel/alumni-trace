<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getTotalAlumni');
        DB::unprepared(
            'CREATE FUNCTION getTotalAlumni() RETURNS INT
            BEGIN
                DECLARE alumniCount INT;
                SELECT COUNT(id_alumni) INTO alumniCount FROM alumni;
                RETURN alumniCount;
            END'
        );
    }

    public function down(): void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getTotalAlumni');
    }
    
};