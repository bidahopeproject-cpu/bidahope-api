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
        Schema::create('transplant_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organ_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_waitlist_id')->nullable()->constrained()->nullOnDelete();

            $table->date('schedule_date');
            $table->time('schedule_time')->nullable();

            $table->enum('status', ['scheduled', 'completed', 'cancelled'])
                ->default('scheduled');

            $table->text('remarks')->nullable();

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
