<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('method')->nullable(); // crypto / card
            $table->string('crypto_type')->nullable(); // BTC, ETH, USDT
            $table->string('wallet_address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['method', 'crypto_type', 'wallet_address']);
        });
    }
};

