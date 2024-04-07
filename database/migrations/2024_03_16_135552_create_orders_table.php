<?php

use App\Models\Order;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->bigInteger('amount');
            $table->text('description');
            $table->enum('type', Order::TYPES)->default(Order::PURCHASE);
            $table->enum('purchase_type', Order::PURCHASE_TYPES)->default(Order::SERVER);
            $table->enum('method', Order::METHODS)->default(Order::CRYPTO);
            $table->enum('status', Order::STATUSES)->default(Order::PENDING);
            $table->string('checkout_url');
            $table->bigInteger('purchase_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
