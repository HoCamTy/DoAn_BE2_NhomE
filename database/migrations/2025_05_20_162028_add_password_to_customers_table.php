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
    Schema::table('customers', function (Blueprint $table) {
        $table->string('password', 255)->change();
    });
}

public function down()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->string('password', 20)->change(); // nếu ban đầu là 20
    });
}


};
