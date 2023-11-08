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
    //melakukan stored procedure untuk sebuah Createforum
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
            
            START TRANSACTION;
            SAVEPOINT satu;
    
            -- Sisipkan data ke dalam tabel forum
            INSERT INTO forum (id_pembuat, judul, content, attachment, status, tanggal_post) VALUES (new_id_pembuat, new_judul, new_content, new_attachment, new_status, new_tanggal_post);
            
            -- Rollback jika terdapat pesan_error
            IF pesan_error != '0000' THEN ROLLBACK TO satu;
            END IF;

            -- Dapatkan id forum yang baru disisipkan
            SET new_id_forum = LAST_INSERT_ID();
            
            -- Melakukan commit pada tabel forum jika berhasil
            IF pesan_error != '0000' THEN ROLLBACK TO satu;
            END IF;
            COMMIT;
    
            
        END
    ");
    //melakukan stored procedure untuk CreateKomentar
    DB::unprepared('DROP Procedure IF EXISTS CreateKomentar');
    DB::unprepared("
    CREATE PROCEDURE CreateKomentar(
       IN new_forum_id INT,
       IN new_id_pembuat INT,
       IN new_komentar TEXT,
       IN new_attachment TEXT,
       IN new_tanggal_post DATE
    )
    BEGIN
        DECLARE pesan_error char(5) DEFAULT '0000';
        DECLARE CONTINUE HANDLER FOR  SQLEXCEPTION, SQLWARNING
        
        BEGIN
        GET DIAGNOSTICS CONDITION 1
        pesan_error = RETURNED_SQLSTATE;
        END;
        
        START TRANSACTION;
        SAVEPOINT satu;

        -- Sisipkan data ke dalam tabel komentar
        INSERT INTO komentar (id_forum, id_pembuat, komentar, attachment, tanggal_post) VALUES 
        (new_forum_id, new_id_pembuat, new_komentar, new_attachment, new_tanggal_post);
        
        -- Rollback jika terdapat pesan_error
        IF pesan_error != '0000' THEN ROLLBACK TO satu;
        END IF;

        -- Dapatkan id forum yang baru disisipkan
        SET new_forum_id = LAST_INSERT_ID();
        
        -- Melakukan commit pada tabel komentar jika berhasil
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
