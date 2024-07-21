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
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('fee_id');
            $table->timestamps();

            $table->index('subscription_id', 'redirect_subscription_idx');
            $table->index('fee_id', 'redirect_fee_idx');

            $table->foreign('subscription_id', 'redirect_subscription_fk')->references('id')->on('subscriptions')->cascadeOnDelete();
            $table->foreign('fee_id', 'redirect_fee_fk')->references('id')->on('fees')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redirects');
    }
};
