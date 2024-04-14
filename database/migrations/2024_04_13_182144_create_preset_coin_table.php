<?php

use App\Models\Coin;
use App\Models\Preset;
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
        Schema::create('preset_coin', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Preset::class);
            $table->foreignIdFor(Coin::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preset_coin');
    }
};
