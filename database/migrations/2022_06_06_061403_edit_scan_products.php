<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditScanProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // if(Schema::table('scan_products'))
        Schema::table('scan_products',function(Blueprint $table){
                $table->date('best_before')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scan_products', function (Blueprint $table) {
            $table->date('best_before')->change();
        });
    }
}
