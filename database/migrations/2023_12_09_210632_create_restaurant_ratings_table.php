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
        Schema::create('restaurant_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->references('id')->on('restaurants')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('rating',[1,2,3,4,5])->nullable(false);
            $table->unique(['restaurant_id','user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_ratings');
    }
};
