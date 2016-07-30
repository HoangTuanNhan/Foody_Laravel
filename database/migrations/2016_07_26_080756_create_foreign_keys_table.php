<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('foods', function(Blueprint $table) {
            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
         Schema::table('foods', function(Blueprint $table) {
            $table->foreign('author')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
         Schema::table('foods', function(Blueprint $table) {
            $table->dropForeign('category_id');
        });
          Schema::table('foods', function(Blueprint $table) {
            $table->dropForeign('author');
        });
    }

}
