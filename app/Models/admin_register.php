<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class admin_register extends Authenticatable
{
    use HasFactory;
    protected $table = 'farmer_registers';
    protected $fillable = [
        'username','email','mobile','dob','division','address',
        'gender','password','profile_pic','condition'
    ];

    protected $hidden = ['password'];
}
