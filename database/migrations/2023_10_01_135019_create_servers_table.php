<?php

use App\Enums\ServerStatus;
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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->enum('status', ServerStatus::values())->default(ServerStatus::IDLE);
            $table->timestamp('last_work_at')->nullable();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Configuration::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
