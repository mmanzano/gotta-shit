<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CascadeAndSoftDeletingPlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('place_comments', function ($table) {
            $table->softDeletes();

            $table->dropForeign('place_comments_place_id_foreign');

            $table->foreign('place_id')
                ->references('id')->on('places')
                ->onDelete('cascade')->change();
        });

        Schema::table('place_stars', function ($table) {
            $table->softDeletes();

            $table->dropForeign('place_stars_place_id_foreign');

            $table->foreign('place_id')
                ->references('id')->on('places')
                ->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('place_comments', function ($table) {
            $table->dropColumn(['deleted_at']);

            $table->dropForeign('place_comments_place_id_foreign');

            $table->foreign('place_id')
                ->references('id')->on('places')
                ->change();
        });

        Schema::table('place_stars', function ($table) {
            $table->dropColumn(['deleted_at']);

            $table->dropForeign('place_stars_place_id_foreign');

            $table->foreign('place_id')
                ->references('id')->on('places')
                ->change();
        });
    }
}
