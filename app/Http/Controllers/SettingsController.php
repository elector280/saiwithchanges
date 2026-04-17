<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['setting'] = DB::table('settings')->first();

        return view('admin.settings.index', $data);
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
        $request->validate([
            'logo' => 'required|mimes:png,jpg,webp|max:2048',
            'favicon' => 'required|max:100',
            'company_name' => 'required|max:30',
            'email' => 'required|max:50',
            'contact_no' => 'required|max:20',
            'facebook' => 'max:100',
            'instagram' => 'max:100',
            'youtube' => 'max:100'
        ]);

        $img = time() . '.' . $request->logo->getClientOriginalExtension();
        $path = 'images/logos/';

        DB::table('settings')->insert([
            'favicon' => $request->favicon,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'logo' => $path . $img
        ]);

        $request->logo->move(public_path($path), $img);

        return redirect()->back()->with('success', 'Setting Added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $setting = DB::table('settings')->where('id', $id)->first();

        return view('admin.settings.edit')->with('setting', $setting);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'logo' => 'nullable|mimes:png,jpg,webp|max:2048',
            'favicon' => 'required|max:100',
            'company_name' => 'required|max:30',
            'email' => 'required|max:50',
            'contact_no' => 'required|max:20',
            'facebook' => 'max:100',
            'instagram' => 'max:100',
            'youtube' => 'max:100'
        ]);

        if ($request->hasFile('logo')) {
        // delete old logo and upload new one
            $oldImg = DB::table('settings')->where('id', $id)->first();

            if ($oldImg) {
                // Build the full path to the logo
                $imagePath = public_path($oldImg->logo);

                // Check if the file exists before deleting
                if (!empty($oldImg->logo) && File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $img = time() . '.' . $request->logo->getClientOriginalExtension();
            $path = 'images/logos/';

            DB::table('settings')->where('id', $id)->update([
                'favicon' => $request->favicon,
                'company_name' => $request->company_name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'logo' => $path . $img,
            ]);

            $request->logo->move(public_path($path), $img);
        }
        else
        {
            DB::table('settings')->where('id', $id)->update([
                'favicon' => $request->favicon,
                'company_name' => $request->company_name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Setting Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Fetch the image path from DB first
        $setting = DB::table('settings')->where('id', $id)->first();


        if ($setting) {
            // Build the full path to the image
            $imagePath = public_path($setting->logo);

            // Check if the file exists before deleting
            if (!empty($setting->logo) && File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Delete the record from database
            DB::table('settings')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Setting deleted successfully.');
        }

        return redirect()->back()->with('error', 'Setting not found.');
    }
}
