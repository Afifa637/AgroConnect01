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
        Schema::create('admin_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',20)->unique();
            $table->string('email',40)->unique();
            $table->string('mobile',12);
            $table->date('dob');
            $table->string('division',25);
            $table->string('address',50);
            $table->string('gender',10);
            $table->string('password',255);
            $table->string('profile_pic',70)->nullable();
            $table->string('condition',15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_registers');
    }
};
