<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersSocialite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('github_id')->unique()->nullable();
            $table->string('facebook_id')->unique()->nullable();
            $table->string('twitter_id')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->string('full_name')->nullable()->change();
            $table->string('password', 60)->nullable()->change();
            $table->string('username')->unique()->nullable()->change();
            $table->string('email')->nullable()->change();
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
            $table->dropColumn(['github_id', 'facebook_id', 'twitter_id', 'avatar']);
        });
    }
}
