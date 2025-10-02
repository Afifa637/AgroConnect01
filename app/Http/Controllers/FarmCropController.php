<?php

namespace App\Http\Controllers;

use App\Models\crop_import;
use App\Models\CropImport;
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
            'username'         => 'required|string',
            'crop_name'        => 'required|string|max:150',
            'crop_session'     => 'nullable|string',
            'crop_type'        => 'nullable|string',
            'crop_quantity'    => 'required|numeric',
            'crop_location'    => 'required|string',
            'bid_rate'         => 'required|numeric',
            'crop_description' => 'nullable|string',
            'last_date_bidding'=> 'required|date',
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
            'crop_name'        => 'required|string|max:150',
            'crop_quantity'    => 'required|numeric',
            'crop_location'    => 'required|string',
            'bid_rate'         => 'required|numeric',
            'last_date_bidding'=> 'required|date',
            'crop_image'       => 'nullable|image|max:2048',
            'crop_image2'      => 'nullable|image|max:2048',
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
}
