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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('offer_id');
            $table->text('referal_link')->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index('user_id', 'subscription_user_idx');
            $table->index('offer_id', 'subscription_offer_idx');

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnDelete();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
