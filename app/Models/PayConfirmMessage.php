<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayConfirmMessage extends Model
{
    //
   protected $fillable=['crop_id','bid_message_id','f_username','crop_name','cust_username','account_type','account_id','confirm_price','message'];
   public function farmer()
   {
       return $this->belongsTo(Farmer_register::class, 'f_username', 'username');
   }

   public function customer()
   {
       return $this->belongsTo(User_register::class, 'cust_username', 'username');
   }

   public function bid()
   {
       return $this->belongsTo(Bid_message::class, 'bid_message_id');
   }
}
