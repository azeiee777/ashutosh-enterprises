<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_person');
            $table->string('mobile', 20);
            $table->string('email')->nullable();
            $table->string('gst', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('status');
            $table->index('company_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
