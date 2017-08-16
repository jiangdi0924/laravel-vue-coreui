<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsrBsrTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bsr_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bsr_id')->nullable()->comment('bsr_id');
            $table->string('url')->nullable()->comment('用户添加的bsr url');
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
        Schema::dropIfExists('usr_bsr_temps');
    }
}
