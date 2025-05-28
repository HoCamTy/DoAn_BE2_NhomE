<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Tạo bảng 'staffs' nếu chưa tồn tại.
     */
    public function up(): void
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id(); // bigIncrements mặc định
            $table->string('staff_name', 100);
            $table->string('staff_phone', 15);
            $table->string('email', 100)->unique()->nullable(); // Cho phép null để linh hoạt
            $table->timestamps();
        });
    }

    /**
     * Xoá bảng 'staffs', đảm bảo tắt ràng buộc khoá ngoại trước.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('staffs');
        Schema::enableForeignKeyConstraints();
    }
};
