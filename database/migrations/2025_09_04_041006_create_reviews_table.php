<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained('destinations')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('guest_name')->nullable();
            $table->unsignedTinyInteger('rating'); // 1..5
            $table->text('review')->nullable();
            $table->timestamps();
            $table->index(['destination_id','rating']);
        });
    }
    public function down(): void { Schema::dropIfExists('reviews'); }
};
