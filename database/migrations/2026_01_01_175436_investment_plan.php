<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('investment_plans', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('min_amount', 10, 2);
        $table->decimal('max_amount', 10, 2);
        $table->integer('duration_days'); // e.g. 30 days
        $table->decimal('roi_percent', 5, 2); // e.g. 8%
        $table->text('features')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop
        Schema::dropIfExists('investment_plans');
    }
};

