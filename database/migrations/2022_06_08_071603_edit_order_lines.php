<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditOrderLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('order_lines', function (Blueprint $table) {
            $table->string('or_plu')->after('order_id')->nullable();
            $table->string('or_gtin')->after('or_plu')->nullable();
            $table->string('or_prod_name')->after('or_gtin')->nullable();
            $table->string('or_qty')->after('or_prod_name')->nullable();
            $table->string('order_type')->after('or_qty')->nullable();
            // $table->string('customer_id')->after('product_name')->default('1');

            if (Schema::hasColumn('order_lines', 'plu')) {
            	$table->renameColumn('plu', 'sc_plu');
            }
            if (Schema::hasColumn('order_lines', 'product_name')) {
            	$table->renameColumn('product_name', 'sc_prod_name');

            }
            if (Schema::hasColumn('order_lines', 'qty')) {
            	$table->renameColumn('qty', 'sc_qty');
            }
            $table->string('sc_gtin')->after('plu')->nullable();
        });

        Schema::table('order_lines', function(Blueprint $table){
            $table->string('sc_plu')->nullable()->change();
            $table->string('sc_prod_name')->nullable()->change();
            $table->string('sc_qty')->nullable()->change();
        });

        if(Schema::hasColumn('orders','order_qty')){
            Schema::dropColumns('orders','order_qty');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        if(Schema::hasColumn('order_lines','or_plu')){
            Schema::dropColumns('order_lines','or_plu');
        }
        if(Schema::hasColumn('order_lines','or_gtin')){
            Schema::dropColumns('order_lines','or_gtin');
        }
        if(Schema::hasColumn('order_lines','or_prod_name')){
            Schema::dropColumns('order_lines','or_prod_name');
        }
        if(Schema::hasColumn('order_lines','or_qty')){
            Schema::dropColumns('order_lines','or_qty');
        }
        if(Schema::hasColumn('order_lines','order_type')){
            Schema::dropColumns('order_lines','order_type');
        }

        Schema::table('order_lines', function(Blueprint $table){
            if (Schema::hasColumn('order_lines', 'sc_plu')) {
                $table->renameColumn('sc_plu', 'plu');
            }
            if (Schema::hasColumn('order_lines', 'sc_prod_name')) {
                $table->renameColumn('sc_prod_name', 'product_name');
            }
            if (Schema::hasColumn('order_lines', 'sc_qty')) {
            	$table->renameColumn('sc_qty', 'qty');
            }
            if (Schema::hasColumn('order_lines', 'sc_gtin')) {
                Schema::dropColumns('order_lines','sc_gtin');
            }
        });

        Schema::table('orders', function(Blueprint $table){
            $table->string('order_qty')->nullable();
        });
    }
}
