<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConnectColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add these to your users table
            $table->text('last_name')->nullable();
            $table->integer('cid')->nullable();
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->unsignedBigInteger('token_expires')->nullable();
            $table->string('roles')->default('member')->nullable();
            $table->string('rating')->nullable();
            $table->string('region')->nullable();
            $table->string('pilot_rating')->nullable();
            $table->string('division')->nullable();
            $table->string('subdivision')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('cid');
            $table->dropColumn('token_expires');
            $table->dropColumn('refresh_token');
            $table->dropColumn('access_token');
            $table->dropColumn('roles');
            $table->dropColumn('rating');
            $table->dropColumn('pilot_rating');
            $table->dropColumn('division');
            $table->dropColumn('subdivision');
            $table->dropColumn('region');
        });
    }
}
