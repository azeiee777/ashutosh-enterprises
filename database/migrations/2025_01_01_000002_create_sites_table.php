<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('site_name');
            $table->text('address')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->date('start_date')->nullable();
            $table->string('status')->default('active');
            $table->text('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('client_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
