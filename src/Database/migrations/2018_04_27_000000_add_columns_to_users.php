<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('password');
            $table->integer('authorised')->nullable();
            $table->string('image')->nullable();
            $table->dropColumn('email');
            $table->dropColumn('remember_token');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('authorised');
            $table->dropColumn('image');
            $table->string('password');
            $table->string('email');
            $table->string('remember_token');
        });
    }
}
