<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayConfirmMessage extends Model
{
    //
   protected $fillable=['crop_id','f_username','crop_name','cust_username','account_type','account_id','confirm_price','message'];
}
