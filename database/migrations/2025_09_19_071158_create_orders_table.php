<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Auto increment PK
        
            $table->string('f_username', 15);
            $table->string('c_username', 15);
        
            $table->unsignedBigInteger('crop_id'); // Foreign key to crops
        
            $table->string('name', 25);
            $table->string('email', 30);
            $table->string('phone', 15);
            $table->double('bid_price', 10, 2);
            $table->double('amount', 10, 2);
            $table->string('address', 80);
            $table->string('division', 15);
            $table->string('zip', 10);
            $table->string('status', 10);
            $table->string('transaction_id', 30);
            $table->string('currency', 10);
            $table->timestamps();
        
            // Foreign keys
            $table->foreign('crop_id')
                  ->references('id')->on('crop_imports')
                  ->onDelete('cascade');
        
            $table->foreign('f_username')
                  ->references('username')->on('crop_imports')
                  ->onDelete('cascade');
        
            $table->foreign('c_username')
                  ->references('username')->on('user_registers')
                  ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
