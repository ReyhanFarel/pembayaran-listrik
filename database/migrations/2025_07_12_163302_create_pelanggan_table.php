<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id(); // Primary key otomatis 'id'
            $table->string('nama_pelanggan', 100);
            $table->string('alamat', 200)->nullable();
            $table->foreignId('tarifs_id')->constrained('tarifs')->onDelete('restrict'); // Foreign key ke tabel 'tarif'

            // --- Tambahan Penting: Kolom Login untuk Pelanggan ---
            $table->string('username', 50)->unique();
            $table->string('password', 100);
            $table->string('remember_token', 100)->nullable(); // Untuk fitur "ingat saya"
            // --- Akhir Tambahan ---

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};