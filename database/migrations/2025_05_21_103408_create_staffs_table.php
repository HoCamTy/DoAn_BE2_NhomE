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
      Schema::create('staffs', function (Blueprint $table) {
    $table->id();
    $table->string('staff_name',100);
        $table->string('staff_phone',15)->unique();
    $table->string('email',100);
    // $table->string('position')->nullable();
    $table->timestamps();
});



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
