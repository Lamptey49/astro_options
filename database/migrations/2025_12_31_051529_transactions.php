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
        Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->enum('type',['deposit','withdrawal','profit']);
        $table->string('crypto')->nullable();
        $table->string('tx_hash')->nullable();
        $table->decimal('amount',12,2);
        $table->enum('status',['pending','approved','rejected'])->default('pending');
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
