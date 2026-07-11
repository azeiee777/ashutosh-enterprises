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
        Schema::table('daily_labour_supplies', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['site_id']);
            // Make site_id nullable and re-add constraint with nullOnDelete
            $table->foreignId('site_id')->nullable()->change()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_labour_supplies', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->foreignId('site_id')->nullable(false)->change()->constrained()->cascadeOnDelete();
        });
    }
};
