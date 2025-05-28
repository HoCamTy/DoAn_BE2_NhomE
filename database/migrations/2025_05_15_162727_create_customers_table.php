<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 100)->nullable();
            $table->string('phone', 15)->unique();
            $table->string('email', 100)->nullable();
            $table->string('password')->nullable();
            $table->text('address')->nullable();
            $table->timestamp('create_date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Tắt kiểm tra khóa ngoại
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    Schema::dropIfExists('customers');

    // Bật lại kiểm tra khóa ngoại
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Schema::dropIfExists('customers');
    }
};
