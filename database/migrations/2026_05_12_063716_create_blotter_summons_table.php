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
        Schema::create('blotter_summons', function (Blueprint $table) {
            $table->id('summon_id');
            $table->unsignedBigInteger('blotter_id');
            $table->dateTime('summon_date');
            $table->enum('summon_type', ['First', 'Second', 'Third']);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('blotter_id')->references('blotter_id')->on('blotter_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blotter_summons');
    }
};
