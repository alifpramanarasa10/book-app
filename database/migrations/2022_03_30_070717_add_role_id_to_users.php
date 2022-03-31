<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // php artisan migrate
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->after('phone');
            /*
            * 1 = admin
            * 2 = staff
            * 3 = user
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // php artisan migration:rollback
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });
    }
};
