<?php

namespace App\Http\Controllers;

use App\Models\OurValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OurValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $values = OurValue::get();
        return view('admin.values.index', compact('values'));
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

        $value = new OurValue();
        $value->title = $request->title;
        $value->description = $request->description;

        // ✅ Logo upload
        if ($request->hasFile('image')) {
            $file = $request->image;
            $ext = '.' . $file->getClientOriginalExtension();
            $logoName = time() . '_logo' . $ext;

            Storage::disk('public')->put(
                'value_image/' . $logoName,
                File::get($file)
            );

            // save filename in DB
            $value->image = $logoName;
        }

        // track creator
        $value->addedby_id = auth()->id();

        $value->save();

        return redirect()
            ->back()
            ->with('success', 'Sponsor item stored successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OurValue $ourValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OurValue $ourValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $ourValue = OurValue::findOrFail($id);
        $ourValue->title = $request->title;
        $ourValue->description = $request->description;

        // ✅ Logo upload
        if ($request->hasFile('image')) {
             // 🔥 delete old logo
            if ($ourValue->image &&
                Storage::disk('public')->exists('value_image/'.$ourValue->image)) {
                Storage::disk('public')->delete('value_image/'.$ourValue->image);
            }

            $file = $request->image;
            $ext = '.' . $file->getClientOriginalExtension();
            $logoName = time() . '_logo' . $ext;

            Storage::disk('public')->put(
                'value_image/' . $logoName,
                File::get($file)
            );

            // save filename in DB
            $ourValue->image = $logoName;
        }

        // track creator
        $ourValue->editedby_id = auth()->id();

        $ourValue->save();

        return redirect()
            ->back()
            ->with('success', 'Sponsor item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $ourValue = OurValue::findOrFail($id);
        if ($ourValue->image && Storage::disk('public')->exists('value_image/'.$ourValue->image)) {
            Storage::disk('public')->delete('value_image/'.$ourValue->image);
        }

        $ourValue->delete();

        return redirect()->back()->with('success', 'Values item deleted successfully!');
    }
}
