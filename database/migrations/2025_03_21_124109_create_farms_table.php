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
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('farm_name');
            $table->string('owner_name');
            $table->string('phone_number');
            $table->text('address');
            $table->string('unique_id')->unique();
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->boolean('is_active')->default(true);
            $table->string('photo_url')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('remarks')->nullable();
            $table->foreignId('created_by');
            $table->foreignId('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms');
    }
};
