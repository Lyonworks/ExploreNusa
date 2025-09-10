<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('trending_tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->nullable()->constrained('destinations')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('trending_tours');
    }
};
