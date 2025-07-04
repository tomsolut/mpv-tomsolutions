<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\DeviceType;
use App\Models\Manufacturer;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Manufacturer::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(DeviceType::class)->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->unsignedInteger('recall_period')->comment('In days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
