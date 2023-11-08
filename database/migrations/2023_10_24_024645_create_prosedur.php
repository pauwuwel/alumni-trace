<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     //membuat create forum dengan sql prosedur
    public function up(): void
    {
        DB::unprepared('DROP Procedure IF EXISTS Createforum');
        DB::unprepared("
        CREATE PROCEDURE Createforum(
            IN new_id_pembuat INT,
            IN new_judul VARCHAR(60), -- Menggunakan integer untuk foregin key
            IN new_content TEXT,
            IN new_attachment TEXT,
            IN new_status ENUM('pending','accepted','rejected'),
            IN new_tanggal_post DATE
        )
        BEGIN
            DECLARE new_id_forum INT;
            DECLARE pesan_error char(5) DEFAULT '0000';
            DECLARE CONTINUE HANDLER FOR  SQLEXCEPTION, SQLWARNING
            
            BEGIN
            GET DIAGNOSTICS CONDITION 1
            pesan_error = RETURNED_SQLSTATE;
            END;
            
        -- membuat rollback forum    
            START TRANSACTION;
            SAVEPOINT satu;
    
            -- Sisipkan data ke dalam tabel forum
 
            
            INSERT INTO forum (id_pembuat, judul, content, attachment, status, tanggal_post) VALUES (new_id_pembuat, new_judul, new_content, 
            new_attachment, new_status, new_tanggal_post);
            
            IF pesan_error != '0000' THEN ROLLBACK TO satu;
            END IF;

            -- Dapatkan ID kelas yang baru disisipkan
            SET new_id_forum = LAST_INSERT_ID();

            IF pesan_error != '0000' THEN ROLLBACK TO satu;
            END IF;
            COMMIT;
    
        
        END
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stored_procedure');
    }
};