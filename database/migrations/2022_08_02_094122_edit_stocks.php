<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('stocks',function(Blueprint $table){
            if (Schema::hasColumn('stocks', 'qty')) {
                $table->dropColumn('qty');
            }
        });
        Schema::table('stocks',function(Blueprint $table){
            if (Schema::hasColumn('stocks', 'best_before')) {
                $table->dropColumn('best_before');
            }
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
        Schema::create('stocks', function (Blueprint $table) {
            $table->string('qty')->nullable();
            $table->date('best_before')->nullable();
        });
    }
}
