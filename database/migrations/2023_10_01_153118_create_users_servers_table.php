<?php

use App\Models\Server;
use App\Models\ServerLog;
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
        Schema::create('users_servers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Server::class);
            $table->foreignIdFor(ServerLog::class)->nullable();
            $table->timestamp('active_until')->nullable();
            $table->timestamp('last_work_at')->nullable();
            $table->enum('status', Server::STATUSES);
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_servers');
    }
};
