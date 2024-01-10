<?php

use App\Models\Transaction;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->bigInteger('amount');
            $table->text('description');
            $table->enum('type', Transaction::TYPES);
            $table->enum('purchase_type', Transaction::PURCHASE_TYPES)->nullable();
            $table->enum('status', Transaction::STATUSES)->default(Transaction::PENDING);
            $table->bigInteger('purchase_id')->nullable();
            $table->bigInteger('payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
