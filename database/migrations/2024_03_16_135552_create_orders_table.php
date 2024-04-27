<?php

use App\Enums\OrderMethod;
use App\Enums\OrderPurchaseType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Configuration;
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
            $table->foreignIdFor(Configuration::class)->nullable();
            $table->bigInteger('amount');
            $table->text('description');
            $table->enum('type', OrderType::values())->default(OrderType::PURCHASE);
            $table->enum('purchase_type', OrderPurchaseType::values())->nullable();
            $table->enum('method', OrderMethod::values())->default(OrderMethod::CRYPTO);
            $table->enum('status', OrderStatus::values())->default(OrderStatus::PENDING);
            $table->string('checkout_url')->nullable();
            $table->bigInteger('purchase_id')->nullable();
            $table->integer('count')->default(1);
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
