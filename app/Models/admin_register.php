<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class admin_register extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    protected $table = 'admin_registers';
    protected $fillable = ['username', 'email', 'mobile', 'dob', 'division', 'address', 'gender', 'password', 'profile_pic', 'condition'];
    // hide password from array/json outputs
    protected $hidden = ['password'];

    // ensure timestamps are active (your migration uses them)
    public $timestamps = true;
}
