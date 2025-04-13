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
        Schema::create('service_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id');
            $table->foreignId('service_category_id');
            $table->integer('species_number_flock')->nullable();
            $table->integer('species_number_infected')->nullable();
            $table->integer('species_number_dead')->nullable();
            $table->string('species_type_species')->nullable();
            $table->string('species_type_breed')->nullable();
            $table->enum('species_type_gender', ['male', 'female'])->nullable();
            $table->string('species_type_age')->nullable();
            $table->text('history_of_disease')->nullable();
            $table->text('symptoms_of_disease')->nullable();
            $table->text('microscopic_result')->nullable();
            $table->foreignId('disease_id')->nullable();
            $table->foreignId('prescription_id')->nullable();
            $table->foreignId('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_records');
    }
};
