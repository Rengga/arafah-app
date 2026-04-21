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
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users');
            
            $table->string('nama_pasien'); 
            
            $table->dateTime('waktu_pemeriksaan');
            $table->float('tinggi_badan');
            $table->float('berat_badan');
            $table->integer('systole');
            $table->integer('diastole');
            $table->integer('heart_rate');
            $table->integer('respiration_rate');
            $table->float('suhu');
            $table->text('catatan');
            $table->string('berkas_pemeriksaan')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};