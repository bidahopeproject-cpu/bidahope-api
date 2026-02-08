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
        Schema::create('organ_donations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organ_id')->constrained()->cascadeOnDelete();

            $table->date('donation_date');
            $table->string('status')->default('available'); 
            // available | used | expired

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
