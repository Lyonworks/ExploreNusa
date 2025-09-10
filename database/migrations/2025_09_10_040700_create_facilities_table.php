<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained('destinations')->cascadeOnDelete();
            $table->string('facility');
            $table->timestamps();
            $table->index(['destination_id','facility']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('facilities');
    }
};
