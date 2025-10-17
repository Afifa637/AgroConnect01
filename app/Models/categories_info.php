<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categories_info extends Model
{
      protected $table = 'categories_infos';
    protected $primaryKey = 'id';
    public $timestamps = true;
      protected $fillable=['a_username','categories_name','categories_description','categories_status'];
}