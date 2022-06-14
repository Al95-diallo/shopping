<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerIdToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // $table->integer('customer_id')->nullable();
            // $table->string('payment_status')->nullable();
        //     $table->foreign('customer_id')
        //     ->references('id')->on('customers');

        // $table->foreign('payment_status')
        //     ->references('id')->on('payments');
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['payment_status']);

            
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('CASCADE')->onUpdate('CASCADE');
            // $table->foreign('payment_status')->references('id')->on('payments')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
}
