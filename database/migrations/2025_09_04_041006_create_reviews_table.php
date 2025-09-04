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
            $table->unsignedTinyInteger('rating'); // 1..5
            $table->text('review')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->index(['destination_id','rating']);
        });
    }
    public function down(): void { Schema::dropIfExists('reviews'); }
};
