<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\farmer_register;
use App\Models\news_info;
use App\Models\user_register;
use App\Models\categories_info;
use App\Models\crop_import;
use App\Models\ContactMessage;
use Carbon\Carbon;

class HomeController extends Controller
{
    // Homepage
    public function index()
    {
        $categories = categories_info::where('categories_status', 1)->get();
        $latestNews = news_info::latest()->take(3)->get();
        $crops = crop_import::latest()->take(12)->get();
        return view('home.index', compact('categories', 'latestNews', 'crops'));
    }

    // Static Pages
    public function about()
    {
        return view('home.about_us');
    }

    public function services()
    {
        return view('home.services');
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function gallery()
    {
        return view('home.gallery');
    }

    // News Page
    public function news_info()
    {
        $newses = news_info::latest()->paginate(6);
        return view('home.news_info', compact('newses'));
    }

    // Categories
    public function Categories($crop_type)
    {
        $category = categories_info::findOrFail($crop_type);
        $crops = crop_import::where('crop_type', $crop_type)->get();
        return view('home.categories', compact('category', 'crops'));
    }

    // Session Categories
    public function Session_Categories($crop_type, $crop_session)
    {
        $category = categories_info::findOrFail($crop_type);
        $crops = crop_import::where('crop_type', $crop_type)
                      ->where('crop_session', $crop_session)
                      ->get();
        return view('home.session_categories', compact('category', 'crops', 'crop_session'));
    }

    // Crop Details
    public function crop_details($id)
    {
        $crop = crop_import::findOrFail($id);
        return view('home.crop_details', compact('crop', 'bids_msg'));
    }

    // Search
    public function search(Request $request)
    {
        $query = $request->input('search');
    
        $s = Crop_import::where('crop_name', 'like', "%$query%")
            ->orWhere('crop_description', 'like', "%$query%")
            ->orWhere('crop_location', 'like', "%$query%")
            ->get();
    
        return view('home.search', compact('s'));
    }    

    // Login Page
    public function login()
    {
        return view('home.login');
    }

    // Signup Page
    public function signup()
    {
        return view('home.signup');
    }

    // Contact form handler
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:191',
            'email'   => 'required|email|max:191',
            'phone'   => 'nullable|string|max:40',
            'message' => 'required|string|max:5000',
        ]);

        // Save to DB
        ContactMessage::create($validated);

        // Redirect back to home contact section with success flash
        return redirect()->to(route('home') . '#contact')
                         ->with('contact_success', 'Thanks! Your message has been received. We will contact you soon.');
    }
}
