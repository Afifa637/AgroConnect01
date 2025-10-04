<?php

namespace App\Http\Controllers;

use App\Models\crop_import;
use App\Models\wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    /**
     * Add a crop to wishlist
     */
    public function wishlist_db($id)
    {
        $crop = crop_import::findOrFail($id);

        Wishlist::create([
            'crop_id'    => $crop->id,
            'f_username' => $crop->username,
            'c_username' => Session::get('c_username'),
        ]);

        return redirect('/')->with('msg', '🌿 Crop added to wishlist successfully.');
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
