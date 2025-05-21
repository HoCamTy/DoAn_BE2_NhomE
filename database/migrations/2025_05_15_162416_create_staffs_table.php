<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id(); 
            $table->string('staff_name', 100)->collation('utf8mb4_unicode_ci');
            $table->string('staff_phone', 15)->collation('utf8mb4_unicode_ci')->index(); // Chỉ mục (index)
            $table->string('email', 100)->collation('utf8mb4_unicode_ci')->nullable(); // Có thể null
            $table->date('create_date'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
}
