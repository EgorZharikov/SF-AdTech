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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('url')->nullable(false)->nullable(false);
            $table->decimal('price')->nullable(false);
            $table->text('content')->nullable(false);
            $table->text('image')->nullable(false);
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('status')->default(true);
            
            $table->index('topic_id', 'offer_topic_idx');
            $table->index('user_id', 'offer_user_idx');
            
            $table->foreign('topic_id')->references('id')->on('topics')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
