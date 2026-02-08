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
       Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('patient_code')->unique();
        // Personal Info
        $table->string('first_name');
        $table->string('middle_name')->nullable();
        $table->string('last_name');
        $table->string('suffix')->nullable(); // Jr, Sr, III

        $table->enum('gender', ['male', 'female', 'other'])->nullable();
        $table->date('birth_date')->nullable();

        // Medical Info
        $table->string('blood_type')->nullable(); // A+, O-, etc
        $table->text('medical_condition')->nullable();

        // Address
        $table->json('region')->nullable();
        $table->json('province')->nullable();
        $table->json('city')->nullable();
        $table->json('barangay')->nullable();

        // Contact
        $table->string('contact_number')->nullable();
        $table->string('email')->nullable();

        $table->enum('status', ['alive', 'deceased'])->default('alive');
        $table->date('date_of_death')->nullable();
        $table->string('death_cause')->nullable();

        $table->boolean('is_transplant_waitlist')->default(false);

        // Role
        $table->enum('patient_role', [
            'donor',
            'recipient'
        ]);

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
