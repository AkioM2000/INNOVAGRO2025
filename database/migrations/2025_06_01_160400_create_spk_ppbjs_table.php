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
        Schema::create('spk_ppbjs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen')->unique();
            $table->date('tanggal');
            $table->string('perihal');
            $table->text('keterangan')->nullable();
            $table->string('lampiran')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk_ppbjs');
    }
};
