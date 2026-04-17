<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->latest()->paginate(15);
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',

            'subtitle' => 'nullable|array',
            'subtitle.*' => 'nullable|string|max:255',

            'btn_text' => 'nullable|array',
            'btn_text.*' => 'nullable|string|max:500',

            'bg_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5048',
            'status' => 'nullable|boolean',
            'btn_link' => 'nullable|string|max:255',
            'tax_line' => 'nullable|string|max:255',
        ]);


        $slider = new Slider();
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->btn_text = $request->btn_text;
        $slider->status = $request->boolean('status');

        if ($request->hasFile('bg_image')) {
            $file = $request->file('bg_image');
            $imageName = time() . '_bg.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('sliders/' . $imageName, file_get_contents($file));
            $slider->bg_image = $imageName;
        }

        $slider->save();


        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider created successfully!');
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
    public function edit(Slider $slider)
    {
         return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title' => 'required|array', // must be array
            'title.*' => 'required|string|max:255', // each language code required
            'subtitle' => 'nullable|array',
            'subtitle.*' => 'nullable|string',
            'btn_text' => 'nullable|array',
            'btn_text.*' => 'nullable|string|max:500', // optional max length
            'bg_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5048',
            'status' => 'nullable|boolean',
            'btn_link' => 'nullable|string|max:255',
            'tax_line' => 'nullable|string|max:255',
        ]);

        // checkbox boolean fix
        $data['status'] = $request->boolean('status');

        /*
        |--------------------------------------------------------------------------
        | BG IMAGE UPDATE
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('bg_image')) {
            if ($slider->bg_image && Storage::disk('public')->exists('sliders/'.$slider->bg_image)) {
                Storage::disk('public')->delete('sliders/'.$slider->bg_image);
            }

            $file = $request->bg_image;
            $ext = '.' . $file->getClientOriginalExtension();
            $imageName = time() . '_bg' . $ext;
            Storage::disk('public')->put('sliders/' . $imageName, File::get($file));
            $data['bg_image'] = $imageName;
        }


        $slider->update($data);

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->bg_image && Storage::disk('public')->exists('sliders/'.$slider->bg_image)) {
            Storage::disk('public')->delete('sliders/'.$slider->bg_image);
        }

        $slider->delete();

        return redirect()
            ->route('sliders.index')
            ->with('success', 'Slider deleted successfully!');
    }

    public function toggleStatus(Slider $slider)
    {
        $slider->update(['status' => !$slider->status]);
        return back()->with('success', 'Status updated!');
    }
}
