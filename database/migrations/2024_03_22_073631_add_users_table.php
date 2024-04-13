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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('country_code')->nullable();
            $table->string('city')->nullable();
            $table->boolean('isOperator')->default(false);
            $table->boolean('isManager')->default(false);
            $table->boolean('isArchive')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('users', [
            'first_name',
            'last_name',
            'country_code',
            'city',
            'phone',
            'isOperator',
            'isManager',
            'isArchive',
        ]);
    }
};
