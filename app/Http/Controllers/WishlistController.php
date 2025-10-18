<?php

namespace App\Http\Controllers;

use App\Models\CropImport;
use App\Models\wishlist;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    /**
     * Add a crop to wishlist
     */
    public function wishlist_db($id)
    {
        $c_username = Session::get('c_username');

        if (!$c_username) {
            return redirect()->route('login')->with('msg', '⚠️ Please log in to add items to your wishlist.');
        }
        $crop = CropImport::findOrFail($id);
        $exists = Wishlist::where('crop_id', $crop->id)
            ->where('c_username', $c_username)
            ->exists();
        if ($exists) {
            return back()->with('msg', '💚 This crop is already in your wishlist.');
        }
        Wishlist::create([
            'crop_id'    => $crop->id,
            'f_username' => $crop->username,
            'c_username' => $c_username,
        ]);

        return back()->with('msg', '🌿 Crop added to your wishlist successfully!');
    }

    /**
     * Show wishlist
     */
    public function wishlist($c_username)
    {
        $wishlists = Wishlist::where('c_username', $c_username)->get();
        return view('buyer.wishlist', compact('wishlists'));
    }

    /**
     * Remove crop from wishlist
     */
    public function wishlist_remove($id)
    {
        Wishlist::findOrFail($id)->delete();
        return back()->with('msg', '❌ Item removed from wishlist.');
    }
}
