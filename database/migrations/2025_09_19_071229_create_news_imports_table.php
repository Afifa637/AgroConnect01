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
        Schema::create('news_imports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('news_name',20);
            $table->string('news_description',50);
            $table->string('long_description',255);
            $table->string('news_image',50);
            $table->timestamps();

            $table->foreign('username')->references('username')->on('admin_registers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_imports');
    }
};
