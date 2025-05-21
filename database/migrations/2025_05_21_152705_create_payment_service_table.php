<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payment_service', function (Blueprint $table) {
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('staffs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('payment_service', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropColumn('payment_id');

            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');

            $table->dropForeign(['staff_id']);
            $table->dropColumn('staff_id');
        });
    }
};
