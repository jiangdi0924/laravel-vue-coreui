<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserListingReviewTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_listing_review_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('user_id');
            $table->integer('listing_id')->nullable()->comment('listing_id');
            $table->integer('review_id')->nullable()->comment('review_id');
            $table->string('tag')->nullable()->comment('评论标签');
            $table->tinyInteger('is_good')->nullable()->comment('是否好评');
            $table->timestamps();
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
        Schema::dropIfExists('user_listing_review_tags');
    }
}
