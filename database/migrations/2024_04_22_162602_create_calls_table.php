<?php

use App\Enums\CallStatus;
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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'operator_id')->nullable();
            $table->foreignIdFor(User::class);
            $table->enum('status', CallStatus::values())->default(CallStatus::NOT_CALLED);
            $table->text('comment')->nullable();
            $table->integer('amount')->default(0);
            $table->boolean('isHot')->default(true);
            $table->boolean('isArchive')->default(false);
            $table->boolean('isManagerArchive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
