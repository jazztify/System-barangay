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
        Schema::create('blotter_records', function (Blueprint $table) {
            $table->id('blotter_id');
            $table->string('case_no', 30)->unique();
            $table->unsignedBigInteger('complainant_id');
            $table->unsignedBigInteger('respondent_id');
            $table->string('incident_type', 100);
            $table->date('incident_date');
            $table->string('incident_location', 255)->nullable();
            $table->text('narrative');
            $table->enum('status', ['Unresolved', 'Scheduled', 'Mediation', 'Settled', 'Dismissed', 'Endorsed'])->default('Unresolved');
            $table->date('resolution_date')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->unsignedBigInteger('filed_by')->nullable();
            $table->timestamps();
            
            $table->foreign('complainant_id')->references('resident_id')->on('residents');
            $table->foreign('respondent_id')->references('resident_id')->on('residents');
            $table->foreign('filed_by')->references('user_id')->on('users');
            
            $table->index(['status', 'respondent_id']);
            $table->index(['status', 'complainant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blotter_records');
    }
};
