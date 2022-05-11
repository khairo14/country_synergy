<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePalletHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pallet_histories', function (Blueprint $table) {
            $table->id();
            $table->string('old_pallet_id')->nullable();
            $table->string('new_pallet_id');
            $table->string('item_quantity');
            $table->string('actions');
            $table->string('old_location_id')->nullable();
            $table->string('new_location_id');
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
        Schema::dropIfExists('pallet_histories');
    }
}
