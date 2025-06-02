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
        Schema::table('spk_ppbjs', function (Blueprint $table) {
            $table->unsignedBigInteger('uploaded_by')->nullable()->after('lampiran');
            $table->string('approver_name')->nullable()->after('uploaded_by');
            $table->timestamp('approved_at')->nullable()->after('approver_name');
            $table->text('approval_notes')->nullable()->after('approved_at');
            
            // Foreign key constraint
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spk_ppbjs', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['uploaded_by', 'approver_name', 'approved_at', 'approval_notes']);
        });
    }
};
