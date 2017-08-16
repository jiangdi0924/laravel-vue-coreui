<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCalculate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->comment('user_id');
            $table->integer('listing_id')->nullable()->comment('listing_id');
            $table->float('seller_price')->nullable()->comment('卖家售价');
            $table->float('my_price')->nullable()->comment('我的售价');
            $table->float('channel_fee')->nullable()->comment('平台费');
            $table->float('picking_fee')->nullable()->comment('拣货费');
            $table->float('weight_shipping_fee')->nullable()->comment('重量运费');
            $table->float('warehousing_fee')->nullable()->comment('仓储费');
            $table->float('headline_shipping_fee')->nullable()->comment('头程运费');
            $table->float('promotion_rate')->nullable()->comment('推广占比');
            $table->float('profit_rate')->nullable()->comment('利润率');
            
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
        Schema::dropIfExists('calculate');
    }
}
