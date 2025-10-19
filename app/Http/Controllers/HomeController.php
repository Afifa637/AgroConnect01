<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\news_info;
use App\Models\categories_info;
use App\Models\CropImport;
use App\Models\ContactMessage;
use App\Models\Bid_message;
use App\Models\farmer_register;
use App\Models\user_register;
use Carbon\Carbon;

class HomeController extends Controller
{
    // 🏠 Homepage
    public function index()
    {
        $date = Carbon::now();
        // Update old crops based on bidding date
        $allCrops = CropImport::all();
        foreach ($allCrops as $crop) {
            if ($date->greaterThan($crop->last_date_bidding)) {
                if ($crop->condition !== 'old') {
                    $crop->condition = "old";
                    $crop->save();
                }
            }
        }

        $categories = categories_info::where('categories_status', 1)->get();
        $latestNews = news_info::latest()->take(3)->get();
        $crops = CropImport::where('Action', 'Published')
            ->where('status', "1")
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // featured for hero
        $featured = CropImport::where('Action', 'Published')
            ->where('status', "1")
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // --- Dynamic stats (counts) ---
        $cropsCount = (int) CropImport::where('Action', 'Published')
            ->where('status', "1")
            ->count();

        // Farmers registered
        $farmersCount = (int) farmer_register::count();

        // Verified buyers / users
        $buyersCount = (int) user_register::count();

        // Active categories
        $categoriesCount = (int) categories_info::where('categories_status', 1)->count();

        // pass to view (your existing compact call — ensure all names are included)
        return view('home.index', compact(
            'categories',
            'latestNews',
            'crops',
            'featured',
            'cropsCount',
            'farmersCount',
            'buyersCount',
            'categoriesCount'
        ));
    }

    // ℹ️ Static Pages
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

    // 📰 News Page
    public function news_info()
    {
        $categories = categories_info::where('categories_status', 1)->get();
        $latestNews = news_info::orderBy('created_at', 'desc')->take(10)->get(); // add this
        $newses = news_info::latest()->paginate(6);

        return view('home.news_info', compact('newses', 'categories', 'latestNews'));
    }

    // 🌾 Categories
    public function Categories($crop_type)
    {
        $category = categories_info::findOrFail($crop_type);
        $crops = CropImport::where('crop_type', $crop_type)
            ->where('Action', 'Published')
            ->where('status', "1")
            ->get();
        $categories = categories_info::where('categories_status', 1)->get();
        return view('home.categories', compact('category', 'crops', 'categories'));
    }

    // 🕒 Seasonal Categories
    public function Session_Categories($crop_type, $crop_session)
    {
        $category = categories_info::findOrFail($crop_type);

        $crops = CropImport::where('crop_type', $crop_type)
            ->where('crop_session', $crop_session)
            ->where('Action', 'Published')
            ->where('status', "1")
            ->get();
        $categories = categories_info::where('categories_status', 1)->get();
        return view('home.session_categories', compact('category', 'crops', 'crop_session', 'categories'));
    }

    // 🌱 Crop Details + Bids
    public function crop_details($id)
    {
        $crop = CropImport::findOrFail($id);
        $farmer = farmer_register::where('username', $crop->username)->first();
        $bids_msg = Bid_message::where('crop_id', $id)->get();
        $categories = categories_info::where('categories_status', 1)->get();
        return view('home.crop_details', compact('crop', 'bids_msg', 'categories', 'farmer'));
    }

    // 🔍 Search Functionality
    public function search(Request $request)
    {
        $query = $request->input('search');

        $s = CropImport::where(function ($q) use ($query) {
            $q->where('crop_name', 'like', "%$query%")
                ->orWhere('crop_description', 'like', "%$query%")
                ->orWhere('crop_location', 'like', "%$query%")
                ->orWhere('crop_type', 'like', "%$query%");
        })
            ->where('Action', 'Published')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
        $categories = categories_info::where('categories_status', 1)->get();
        return view('home.search', compact('s', 'categories'));
    }
    // AUTOCOMPLETE endpoint used by header JS
    public function searchAutocomplete(Request $request)
    {
        $q = $request->query('query', '');
        if (strlen($q) < 1) return response()->json([]);
        $items = CropImport::where('crop_name', 'like', "%{$q}%")
            ->where('Action', 'Published')->where('status', "1")
            ->limit(8)->pluck('crop_name');
        return response()->json($items);
    }
    // 🔐 Login Page
    public function login()
    {
        return view('home.login');
    }

    // 📝 Signup Page
    public function signup()
    {
        return view('home.signup');
    }

    // 📬 Contact Form Submission
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:191',
            'email'   => 'required|email|max:191',
            'phone'   => 'nullable|string|max:40',
            'subject' => 'required|string|max:191',
            'message' => 'required|string|max:5000',
        ]);

        // Save to DB
        ContactMessage::create($validated);

        return redirect()->to(route('contact') . '#contact')
            ->with('contact_success', 'Thanks! Your message has been received. We will contact you soon.');
    }

}
