<?php

use App\Models\OperatorReport;
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
        Schema::create('operators_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'operator_id');
            $table->foreignIdFor(User::class);
            $table->enum('status', OperatorReport::REPORT_STATUSES);
            $table->text('comment')->nullable();
            $table->integer('amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators_reports');
    }
};
