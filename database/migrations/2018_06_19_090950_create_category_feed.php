<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryFeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('feed_id')->references('id')->on('feeds')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_feeds');
    }
}
