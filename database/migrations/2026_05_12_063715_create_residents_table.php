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
        Schema::create('residents', function (Blueprint $table) {
            $table->id('resident_id');
            $table->unsignedBigInteger('household_id')->nullable();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->string('suffix', 20)->nullable();
            $table->date('date_of_birth');
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated', 'Divorced'])->default('Single');
            $table->string('nationality', 50)->default('Filipino');
            $table->string('occupation', 100)->nullable();
            $table->string('contact_no', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->date('resident_since')->nullable();
            $table->boolean('is_voter')->default(false);
            $table->boolean('is_pwd')->default(false);
            $table->boolean('is_senior_citizen')->default(false);
            $table->boolean('is_solo_parent')->default(false);
            $table->boolean('is_4ps')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('photo_path', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('household_id')->references('household_id')->on('households')->onDelete('set null');
            $table->index(['last_name', 'first_name']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
