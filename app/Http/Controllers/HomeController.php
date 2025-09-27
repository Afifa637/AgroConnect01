<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\farmer_register;
use App\Models\news_info;
use App\Models\user_register;
use Carbon\Carbon;


class HomeController extends Controller
{
    
    public function index(){

        return view('home.index',);
    }
    public function about(){
        return view('home.about_us');
    }

    public function services(){
  
        return view('home.services');
    }

public function contact(){
        return view('home.contact');
    }

public function gallery(){
        return view('home.gallery');
    }
}
