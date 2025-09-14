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
     Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->enum('room_type', ['single', 'double', 'twin', 'suite', 'deluxe', 'presidential']);
            $table->decimal('price', 10, 2);
            $table->integer('capacity');
            $table->decimal('size', 8, 2)->nullable();
            $table->enum('bed_type', ['king', 'queen', 'double', 'twin', 'single']);
            $table->enum('status', ['available', 'occupied', 'maintenance', 'cleaning']);
            $table->json('amenities')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
