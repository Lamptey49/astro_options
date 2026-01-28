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
        Schema::create('user_investments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('investment_plan_id')->constrained()->cascadeOnDelete();
        $table->decimal('amount', 12, 2);
        $table->decimal('expected_return', 12, 2);
        $table->date('start_date');
        $table->date('end_date');
        $table->enum('status',['active','completed'])->default('active');
        $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_investments');
    }
};
