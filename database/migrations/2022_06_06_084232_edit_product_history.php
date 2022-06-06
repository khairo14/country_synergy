<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditProductHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('product_histories',function(Blueprint $table){
            $table->string('order_id')->after('new_pallet_id')->nullable();
            $table->dateTime('order_out_date')->after('order_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        if (Schema::hasColumn('product_histories', 'order_id')) {
            Schema::dropColumns('product_histories','order_id');
        }

        if(Schema::hasColumn('product_histories','order_out_date')){
            Schema::dropColumns('product_histories','order_out_date');
        }
    }
}
