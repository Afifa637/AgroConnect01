<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin_register;
use App\Models\CropImport;
use App\Models\farmer_register;
use App\Models\news_info;
use App\Models\user_register;
use App\Models\Bid_message;
use App\Models\categories_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\ContactMessage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Protect admin routes with middleware (admin login).
     * Ensure you registered middleware alias 'admin.login' (or change to your alias) in Kernel.php
     */
    // public function __construct()
    // {
    //     $this->middleware('admin.login');
    // }

    // Admin home 
    public function a_home()
    {
        return view('admin.index');
    }

    // Published crops (paginated)
    public function published_crops()
    {
        $crops = CropImport::where('Action', "Published")->paginate(11);
        return view('admin.published_crops', compact('crops'));
    }

    public function unpublished_crops()
    {
        $crops = CropImport::where('Action', "Unpublished")->paginate(11);
        return view('admin.unpublished_crops', compact('crops'));
    }

    public function crop_published_save($id)
    {
        $crop = CropImport::findOrFail($id);
        $crop->Action = "Published";
        $crop->save();
        return redirect()->route('unpublished_crops') // ensure route name exists
            ->with('msg', 'Crop Published Successfully');
    }

    public function crop_unpublished_save($id)
    {
        $crop = CropImport::findOrFail($id);
        $crop->Action = "Unpublished";
        $crop->save();
        return redirect()->route('published_crops') // ensure route name exists
            ->with('msg', 'Crop Unpublished Successfully');
    }

    public function deleted_crops()
    {
        $crops = CropImport::where('Action', "deleted")->get();
        return view('admin.deleted_crops', compact('crops'));
    }

    public function crop_delete($id)
    {
        $crop = CropImport::findOrFail($id);
        $crop->delete();
        return redirect()->route('deleted.crops')->with('msg', 'Crop Delete Successfully');
    }

    // Categories
    public function add_categories()
    {
        return view('admin.add_categories');
    }

    public function save_categories_db(Request $request)
    {
        $request->validate([
            'a_username' => 'required|string',
            'categories_name' => 'required|string|max:255',
            'categories_description' => 'required|string',
        ]);

        $categories = new categories_info();
        $categories->a_username = $request->a_username;
        $categories->categories_name = $request->categories_name;
        $categories->categories_description = $request->categories_description;
        $categories->categories_status = 1;
        $categories->save();

        return redirect()->route('a_home')->with('msg', 'Category added successfully');
    }

    public function manage_categories()
    {
        $categories = categories_info::all();
        return view('admin.manage_categories', compact('categories'));
    }

    public function categories_status($id)
    {
        $categories = categories_info::findOrFail($id);

        $categories->categories_status = $categories->categories_status == 1 ? 0 : 1;
        $categories->save();

        $msg = $categories->categories_status == 1 ? 'category activated successfully' : 'category deactivated successfully';
        return redirect()->route('manage_categories')->with('msg', $msg);
    }

    public function edit_categories($id)
    {
        $categorie = categories_info::findOrFail($id);
        return view('admin.edit_categories', compact('categorie'));
    }

    public function update_categories_db(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'categories_name' => 'required|string|max:255',
            'categories_description' => 'required|string',
        ]);

        $categories = categories_info::where('id', $request->id)->firstOrFail();
        $categories->a_username = $request->a_username;
        $categories->categories_name = $request->categories_name;
        $categories->categories_description = $request->categories_description;
        $categories->categories_status = 1;
        $categories->save();

        return redirect()->route('manage_categories')->with('msg', 'Category updated successfully');
    }

    public function categories_delete($id)
    {
        $categories = categories_info::findOrFail($id);
        $categories->delete();
        return redirect()->route('manage_categories')->with('msg', 'Category deleted successfully');
    }

    // News
    public function add_news()
    {
        return view('admin.add_news');
    }

    public function save_news_db(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'news_name' => 'required|string|max:255',
            'news_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'news_image' => 'required|image|max:5120',
        ]);

        $news = new news_info(); // create the object first
        $news->username = $request->username;
        $news->news_name = $request->news_name;
        $news->news_description = $request->news_description;
        $news->long_description = $request->long_description;

        if ($request->hasFile('news_image')) {
            $file = $request->file('news_image');
            $imageName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                . '.' . $file->getClientOriginalExtension();

            // store in storage/app/public/news_images
            $file->storeAs('public/news_images', $imageName);

            // assign public URL to model
            $news->news_image = 'storage/news_images/' . $imageName;
        }

        $news->save();
        return redirect()->route('a_home')->with('msg', 'News published successfully');
    }


    public function manage_news()
    {
        $newses = news_info::all();
        return view('admin.manage_news', compact('newses'));
    }

    public function edit_news($id)
    {
        $news = news_info::findOrFail($id);
        return view('admin.edit_news', compact('news'));
    }

    public function update_news_db(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'username' => 'required|string',
            'news_name' => 'required|string|max:255',
            'news_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'news_image' => 'nullable|image|max:5120',
        ]);

        $imageUrl = null;
        if ($request->hasFile('news_image')) {
            $file = $request->file('news_image');
            $imageName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/news_images', $imageName);
            $imageUrl = Storage::url('news_images/' . $imageName);
        }

        $news = news_info::where('id', $request->id)->firstOrFail();
        $news->username = $request->username;
        $news->news_name = $request->news_name;
        $news->news_description = $request->news_description;
        $news->long_description = $request->long_description;
        if ($imageUrl) {
            $news->news_image = $imageUrl;
        }
        $news->save();

        return redirect()->route('manage_news')->with('msg', 'News updated successfully');
    }

    public function delete_news($id)
    {
        $news = news_info::findOrFail($id);
        $news->delete();
        return redirect()->route('manage_news')->with('msg', 'News deleted successfully');
    }

    // Admin profile & settings
    public function a_profile()
    {
        $newses = news_info::where('username', Session::get('a_username'))->get();
        return view('admin.a_profile', compact('newses'));
    }

    public function a_settings()
    {
        $user = admin_register::where('username', Session::get('a_username'))->first();
        return view('admin.a_settings', compact('user'));
    }

    // Users
    public function all_farmer()
    {
        $users = farmer_register::all();
        return view('admin.all_farmer', compact('users'));
    }

    public function all_customer()
    {
        $users = user_register::all();
        return view('admin.all_customer', compact('users'));
    }

    public function f_action($id)
    {
        $farm = farmer_register::find($id);

        if ($farm != null) {
            $farm->action = ($farm->action == "active") ? "disable" : "active";
            $farm->save();

            $data = $farm->toArray();
            // send email (keep commented-out if you don't want to send)
            Mail::send('user_action_mail', ['val' => $data], function ($message) use ($data) {
                $message->to($data['email']);
                $message->subject('user_action_mail');
            });

            return redirect()->route('all_farmer')->with('msg', 'Farmer status updated');
        }

        return redirect()->route('all_farmer')->with('msg', 'Farmer not found');
    }

    public function c_action($id)
    {
        $cust = user_register::find($id);

        if ($cust != null) {
            $cust->action = ($cust->action == "active") ? "disable" : "active";
            $cust->save();
            return redirect()->route('customers')->with('msg', 'Customer status updated');
        }

        return redirect()->route('customers')->with('msg', 'Customer not found');
    }

    public function farmer_profile($id)
    {
        $user = farmer_register::findOrFail($id);
        Session::put('fa_login', $user->username);
        $crops = CropImport::where('username', $user->username)->get();
        return view('admin.farmer_profile', compact('crops'));
    }

    public function user_profile($id)
    {
        $user = user_register::findOrFail($id);
        Session::put('c_login', $user->username);
        $crops = Bid_message::where('cust_username', $user->username)->distinct()->get(['crop_id']);
        return view('admin.user_profile', compact('crops'));
    }

    public function user_details($id)
    {
        $user = farmer_register::findOrFail($id);
        return view('admin.user_details', compact('user'));
    }

    public function admin_search(Request $request)
    {
        $search_tx1 = $request->search;

        $search = CropImport::orderBy('id', 'desc')
            ->where(function ($q) use ($search_tx1) {
                $q->where('crop_name', 'LIKE', "%{$search_tx1}%")
                    ->orWhere('crop_type', 'LIKE', "%{$search_tx1}%")
                    ->orWhere('crop_location', 'LIKE', "%{$search_tx1}%");
            })
            ->where('Action', "Published")
            ->where('status', '1')
            ->get();

        return view('admin.search', ['s' => $search]);
    }
    public function contact_messages()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        return view('admin.contact_messages', compact('messages'));
    }
}
