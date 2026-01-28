<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trading_pairs', function (Blueprint $table) {
            $table->id();
            $table->string('symbol'); // BTC/USDT
            $table->decimal('price', 12, 2); // simulated price
            $table->string('base_asset');
            $table->string('quote_asset');
            $table->string('binance_symbol')->nullable(); // e.g. BTCUSDT
            $table->string('icon')->nullable(); // logo path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trading_pairs');
    }
};
