<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_labour_supplies', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('skilled_count')->default(0);
            $table->unsignedInteger('semi_skilled_count')->default(0);
            $table->unsignedInteger('unskilled_count')->default(0);
            $table->unsignedInteger('other_count')->default(0);
            $table->unsignedInteger('total_count')->default(0);
            $table->string('shift')->default('general');
            $table->text('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('date');
            $table->index(['client_id', 'date']);
            $table->index(['site_id', 'date']);
            $table->index(['date', 'client_id', 'site_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_labour_supplies');
    }
};
