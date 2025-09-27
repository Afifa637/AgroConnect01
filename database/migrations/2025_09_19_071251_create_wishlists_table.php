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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id'); // must match crop_imports.id
            $table->string('f_username', 15);
            $table->string('c_username', 15);
            $table->timestamps();
        
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
        Schema::dropIfExists('wishlists');
    }
};
