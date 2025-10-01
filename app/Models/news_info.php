<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class news_info extends Model
{
    protected $table = 'news_imports';
    protected $fillable = ['news_name', 'news_description', 'news_image'];
}
