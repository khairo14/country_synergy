<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditScannedProd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('scan_products',function(Blueprint $table){
            if (Schema::hasColumn('scan_products', 'gtin')) {
                $table->dropColumn('gtin');
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
        Schema::create('scan_products', function (Blueprint $table) {
            $table->string('gtin')->nullable();
        });
    }
}
