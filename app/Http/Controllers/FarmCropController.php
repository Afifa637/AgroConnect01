<?php

namespace App\Http\Controllers;

use App\Models\crop_import;
use App\Models\farmer_register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FarmCropController extends Controller
{
    /**
     * Show crop import form
     */
    public function create()
    {
        return view('farmer.crop_import');
    }

    /**
     * Store crop product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|exists:farmer_registers,username',
            'crop_name' => 'required|string|max:35',
            'crop_session' => 'required',
            'crop_type' => 'required|exists:categories_infos,id',
            'crop_quantity' => 'required|string|max:25', // string if you allow "50kg"
            'crop_location' => 'required|string|max:50',
            'bid_rate' => 'required|numeric|min:1',
            'crop_description' => 'required|string|max:255',
            'last_date_bidding' => 'required|date|after_or_equal:today',
            'crop_image'       => 'nullable|image|max:2048',
            'crop_image2'      => 'nullable|image|max:2048',
        ]);

        $crop = new crop_import($validated);

        if ($request->hasFile('crop_image')) {
            $crop->crop_image = $request->file('crop_image')->store('crop_images', 'public');
        }

        if ($request->hasFile('crop_image2')) {
            $crop->crop_image2 = $request->file('crop_image2')->store('crop_images', 'public');
        }

        $crop->status = 1;
        $crop->condition = "New";
        $crop->Action = "Published";
        $crop->save();

        return redirect()->route('crop_manage')->with('msg', 'Product saved successfully');
    }

    /**
     * Manage crops (list)
     */
    public function index()
    {
        $crops = crop_import::where('username', Session::get('f_username'))
            ->where('Action', '!=', "deleted")
            ->paginate(9);

        return view('farmer.manage_crops', compact('crops'));
    }

    /**
     * Edit crop form
     */
    public function edit($id)
    {
        $crop = crop_import::findOrFail($id);
        return view('farmer.edit_crop', compact('crop'));
    }

    /**
     * Update crop
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'crop_name'         => 'required|string|max:150',
            'crop_type'         => 'required|exists:categories_infos,id',
            'crop_quantity'     => 'required|string|max:25',
            'crop_location'     => 'required|string|max:100',
            'bid_rate'          => 'required|numeric|min:1',
            'crop_description'  => 'required|string|max:255',
            'last_date_bidding' => 'required|date|after_or_equal:today',
            'status'            => 'required|in:0,1',
            'crop_image'        => 'nullable|image|max:2048',
            'crop_image2'       => 'nullable|image|max:2048',
        ]);

        $crop = crop_import::findOrFail($id);
        $crop->fill($validated);

        if ($request->hasFile('crop_image')) {
            $crop->crop_image = $request->file('crop_image')->store('crop_images', 'public');
        }

        if ($request->hasFile('crop_image2')) {
            $crop->crop_image2 = $request->file('crop_image2')->store('crop_images', 'public');
        }

        $crop->condition = "New";
        $crop->Action = "Published";
        $crop->save();

        return redirect()->route('crop_manage')->with('msg', 'Product updated successfully');
    }

    /**
     * Toggle crop status
     */
    public function toggleStatus($id)
    {
        $crop = crop_import::findOrFail($id);
        $crop->status = !$crop->status;
        $crop->save();

        return redirect()->route('crop_manage')->with('msg', 'Crop status updated successfully');
    }

    /**
     * Delete crop (soft delete)
     */
    public function destroy($id)
    {
        $crop = crop_import::findOrFail($id);
        $crop->Action = "deleted";
        $crop->save();

        return redirect()->route('crop_manage')->with('msg', 'Crop deleted successfully');
    }

    /**
     * Show all crops in farmer profile view
     */
    public function profile()
    {
        $username = Session::get('f_username');

        $user = farmer_register::where('username', $username)->first();
        $crops = crop_import::where('username', $username)
            ->where('Action', '!=', 'deleted')
            ->orderByDesc('id')
            ->get();

        return view('farmer.farmer_profile', compact('crops', 'user'));
    }
}
