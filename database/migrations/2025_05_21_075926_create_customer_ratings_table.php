<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->text('comments');
            $table->float('service_rating');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('customer_ratings');
    }
};