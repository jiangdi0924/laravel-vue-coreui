<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserListingKeywords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_listing_keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('user_id');
            $table->integer('listing_id')->nullable()->comment('listing_id');
            $table->integer('keywords_id')->nullable()->comment('keywords_id');
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
        Schema::dropIfExists('user_listing_keywords');
    }
}
