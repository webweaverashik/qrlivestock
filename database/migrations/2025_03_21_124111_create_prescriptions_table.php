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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livestock_type_id')->nullable();
            $table->string('livestock_age')->nullable();
            $table->string('livestock_weight')->nullable();
            $table->text('disease_brief');
            $table->text('medication');
            $table->string('livestock_temp')->nullable();
            $table->string('livestock_pulse')->nullable();
            $table->string('livestock_rumen_motility')->nullable();
            $table->string('livestock_respiratory')->nullable();
            $table->string('livestock_other')->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->foreignId('approved_by')->nullable();
            $table->foreignId('created_by'); // Staff User ID
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
