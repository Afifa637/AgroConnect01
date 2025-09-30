<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class farmer_register extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory;
    protected $table = 'farmer_registers';
    protected $fillable = [
        'register_as','username','email','mobile','dob','division','address',
        'zip_code','gender','password','profile_pic','action','condition','NID_1','NID_2'
    ];

    protected $hidden = ['password'];
}
