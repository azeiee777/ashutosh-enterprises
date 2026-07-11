<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_id')->nullable()->constrained()->nullOnDelete();
            $table->string('payment_head');
            $table->decimal('amount', 12, 2);
            $table->string('payment_method');
            $table->string('paid_to')->nullable();
            $table->text('description')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('attachment_path')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('date');
            $table->index('client_id');
            $table->index('payment_head');
            $table->index(['client_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_records');
    }
};
