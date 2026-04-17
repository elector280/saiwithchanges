<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors = Sponsor::get();
        return view('admin.sponsor.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // dd($request->all());
        // ✅ Validation
        $request->validate([
            'company_name' => 'required|array',
            'company_name.*' => 'required|string|max:255',
            'sub_title' => 'nullable|array',
            'sub_title.*' => 'nullable|string|max:255',
            'content' => 'nullable|array',
            'content.*' => 'nullable|string|max:255',
            'company_logo' => 'required|image|mimes:jpg,jpeg,png,webp',
            'campaign_icon' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $sponsor = new Sponsor();
        $sponsor->company_name = $request->company_name;
        $sponsor->sub_title = $request->sub_title;
        $sponsor->content = $request->content;
        $sponsor->website_link = $request->website_link;
        $sponsor->type         = $request->type;

        // ✅ Logo upload
        if ($request->hasFile('company_logo')) {
            $file = $request->company_logo;
            $ext = '.' . $file->getClientOriginalExtension();
            $logoName = time() . '_logo' . $ext;

            Storage::disk('public')->put(
                'company_logo/' . $logoName,
                File::get($file)
            );

            // save filename in DB
            $sponsor->company_logo = $logoName;
        }


        if ($request->hasFile('campaign_icon')) {
            $file = $request->campaign_icon;
            $ext = '.' . $file->getClientOriginalExtension();
            $logoName = time() . '_logo' . $ext;

            Storage::disk('public')->put(
                'campaign_icon/' . $logoName,
                File::get($file)
            );

            // save filename in DB
            $sponsor->campaign_icon = $logoName;
        }

        // track creator
        $sponsor->addedby_id = auth()->id();

        $sponsor->save();

        return redirect()
            ->back()
            ->with('success', 'Sponsor item stored successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'company_name' => 'required|array',
            'company_name.*' => 'required|string|max:255',
            'sub_title' => 'required|array',
            'sub_title.*' => 'required|string|max:255',
            'content' => 'required|array',
            'content.*' => 'required|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'campaign_icon' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        // update name
        $sponsor->company_name = $request->company_name;
        $sponsor->sub_title = $request->sub_title;
        $sponsor->content = $request->content;
        $sponsor->website_link = $request->website_link;
        $sponsor->type         = $request->type;

        if ($request->hasFile('company_logo')) {

            // 🔥 delete old logo
            if ($sponsor->company_logo &&
                Storage::disk('public')->exists('company_logo/'.$sponsor->company_logo)) {
                Storage::disk('public')->delete('company_logo/'.$sponsor->company_logo);
            }

            // upload new logo
            $file = $request->company_logo;
            $ext = '.' . $file->getClientOriginalExtension();
            $logoName = time() . '_logo' . $ext;

            Storage::disk('public')->put(
                'company_logo/' . $logoName,
                File::get($file)
            );

            // ✅ IMPORTANT: assign new logo to model
            $sponsor->company_logo = $logoName;
        }

        if ($request->hasFile('campaign_icon')) {

            // 🔥 delete old logo
            if ($sponsor->campaign_icon &&
                Storage::disk('public')->exists('campaign_icon/'.$sponsor->campaign_icon)) {
                Storage::disk('public')->delete('campaign_icon/'.$sponsor->campaign_icon);
            }

            // upload new logo
            $file = $request->campaign_icon;
            $ext = '.' . $file->getClientOriginalExtension();
            $logoName = time() . '_logo' . $ext;

            Storage::disk('public')->put(
                'campaign_icon/' . $logoName,
                File::get($file)
            );

            // ✅ IMPORTANT: assign new logo to model
            $sponsor->campaign_icon = $logoName;
        }

        // editor tracking
        $sponsor->editedby_id = auth()->id();

        $sponsor->save();

        return redirect()->back()->with('success', 'Sponsor item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->company_logo && Storage::disk('public')->exists('company_logo/'.$sponsor->company_logo)) {
            Storage::disk('public')->delete('company_logo/'.$sponsor->company_logo);
        }
        $sponsor->delete();

        return redirect()->back()->with('success', 'Sponsor item deleted successfully!');
    }
}
