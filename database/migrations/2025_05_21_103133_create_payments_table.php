<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('payment_service', function (Blueprint $table) {
        $table->id();
        $table->foreignId('payment_id')->constrained()->onDelete('cascade');
        $table->foreignId('service_id')->constrained()->onDelete('cascade');
        $table->foreignId('staff_id')->nullable()->constrained()->onDelete('set null');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
