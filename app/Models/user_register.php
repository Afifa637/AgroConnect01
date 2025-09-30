<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user_register extends Authenticatable
{
    use HasFactory;
    protected $table = 'farmer_registers';
    protected $fillable = [
        'register_as','username','email','mobile','dob','division','address',
        'zip_code','gender','password','profile_pic','action','condition','NID_1','NID_2'
    ];

    protected $hidden = ['password'];
}
