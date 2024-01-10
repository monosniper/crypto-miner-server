<?php

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
        Schema::create('server_possibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Server::class);
            $table->foreignIdFor(\App\Models\Possibility::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_possibilities');
    }
};
