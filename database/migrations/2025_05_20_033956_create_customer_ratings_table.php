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
        Schema::create('customer_ratings', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('customer_id');
    $table->tinyInteger('service_rating');
    $table->text('comments');
    $table->timestamps();

    $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_ratings');
    }
};
