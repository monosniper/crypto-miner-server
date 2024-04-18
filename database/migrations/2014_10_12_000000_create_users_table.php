<?php

use App\Models\Ref;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('token')->nullable();
            $table->json('coin_positions')->nullable();
            $table->boolean('isVerificated')->default(false);
            $table->boolean('isFirstStart')->default(true);
            $table->boolean('isAdmin')->default(false);
            $table->foreignIdFor(Ref::class)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('country_code')->nullable();
            $table->string('city')->nullable();
            $table->boolean('isOperator')->default(false);
            $table->boolean('isManager')->default(false);
            $table->boolean('isArchive')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
