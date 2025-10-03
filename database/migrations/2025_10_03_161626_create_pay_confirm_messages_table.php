<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayConfirmMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_confirm_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bid_message_id'); // links to bid_messages.id
            $table->string('f_username', 20); // references farmer_registers.username
            $table->string('cust_username', 20); // references user_registers.username
            $table->string('crop_name', 15);
            $table->string('account_type', 10);
            $table->string('account_id', 25);
            $table->string('confirm_price', 15);
            $table->string('message', 70);
            $table->timestamps();

            // Foreign keys
            $table->foreign('bid_message_id')
                  ->references('id')
                  ->on('bid_messages')
                  ->onDelete('cascade');

            $table->foreign('f_username')
                  ->references('username')
                  ->on('farmer_registers')
                  ->onDelete('cascade');

            $table->foreign('cust_username')
                  ->references('username')
                  ->on('user_registers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_confirm_messages');
    }
}
