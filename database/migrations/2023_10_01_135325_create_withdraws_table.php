<?php

use App\Enums\WithdrawStatus;
use App\Enums\WithdrawType;
use App\Models\Nft;
use App\Models\User;
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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Nft::class)->nullable();
            $table->string('wallet', 1000);
            $table->bigInteger('amount')->nullable();
            $table->enum('type', WithdrawType::values())
                ->default(WithdrawType::COIN);
            $table->enum('status', WithdrawStatus::values())
                ->default(WithdrawStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
