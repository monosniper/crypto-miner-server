<?php

use App\Enums\Configuration;
use App\Models\ConfigurationField;
use App\Models\ConfigurationGroup;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
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
        Schema::create('configuration_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ConfigurationGroup::class, 'group_id');
            $table->string('slug');
            $table->integer('priority')->nullable();
            $table->enum('type', AsEnumCollection::class.':'.Configuration::class)->default(ConfigurationField::SELECT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuration_fields');
    }
};
