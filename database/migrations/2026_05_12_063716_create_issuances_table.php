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
        Schema::create('issuances', function (Blueprint $table) {
            $table->id('issuance_id');
            $table->unsignedBigInteger('resident_id');
            $table->enum('doc_type', ['Clearance', 'Residency', 'Indigency', 'JobSeeker']);
            $table->string('control_no', 30)->unique();
            $table->string('or_no', 50)->nullable();
            $table->string('purpose', 200);
            $table->boolean('is_free')->default(false);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('issued_by');
            $table->timestamp('issued_at')->useCurrent();
            $table->timestamps();

            $table->foreign('resident_id')->references('resident_id')->on('residents');
            $table->foreign('issued_by')->references('user_id')->on('users');

            $table->index('resident_id');
            $table->index(['doc_type', 'issued_at']);
            $table->index('control_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issuances');
    }
};
