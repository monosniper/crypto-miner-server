<?php

use App\Models\Coin;
use App\Models\Session;
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
        Schema::create('sessions_coins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Session::class);
            $table->foreignIdFor(Coin::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions_coins');
    }
};
