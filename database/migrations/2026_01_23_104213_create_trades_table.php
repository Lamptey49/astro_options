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
       Schema::create('trades', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('pair'); // BTCUSDT
        $table->enum('side', ['buy', 'sell']);
        $table->decimal('entry_price', 16, 8);
        $table->decimal('exit_price', 16, 8)->nullable();
        $table->decimal('amount', 16, 8); // position size in USDT
        $table->decimal('stop_loss', 16, 8)->nullable();
        $table->decimal('take_profit', 16, 8)->nullable();
        $table->decimal('pnl', 16, 8)->nullable();
        $table->enum('mode', ['demo', 'live']);
        $table->enum('status', ['open', 'closed'])->default('open');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
