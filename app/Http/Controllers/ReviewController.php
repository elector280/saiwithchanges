<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::get();
        $campaigns = Campaign::get();
        return view('admin.review.index', compact('reviews', 'campaigns'));
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

        $review = new Review();
        $review->name = $request->name;
        $review->campaign_id = $request->campaign_id;
        $review->description = $request->description;

        // ✅ Logo upload
        if ($request->hasFile('profile_image')) {
            $file = $request->profile_image;
            $ext = '.' . $file->getClientOriginalExtension();
            $logoName = time() . '_profile_' . rand(100, 999) . $ext;
            Storage::disk('public')->put('review_image/' . $logoName, File::get($file));
            $review->profile_image = $logoName;
        }

        if ($request->hasFile('image')) {
            $file = $request->image;
            $ext = '.' . $file->getClientOriginalExtension();
            $logoName = time() . '_image_' . rand(100, 999) . $ext;
            Storage::disk('public')->put('review_image/' . $logoName, File::get($file));
            $review->image = $logoName;
        }

        // track creator
        $review->addedby_id = auth()->id();

        $review->save();

        return redirect()
            ->back()
            ->with('success', 'Review item stored successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->name = $request->name;
        $review->campaign_id = $request->campaign_id;
        $review->description = $request->description;

        /*
        |--------------------------------------------------------------------------
        | PROFILE IMAGE UPDATE
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile_image')) {

            // delete old profile image
            if ($review->profile_image &&
                Storage::disk('public')->exists('review_image/'.$review->profile_image)) {
                Storage::disk('public')->delete('review_image/'.$review->profile_image);
            }

            $file = $request->profile_image;
            $ext = '.' . $file->getClientOriginalExtension();
            $fileName = time() . '_profile_' . rand(100, 999) . $ext;

            Storage::disk('public')->put(
                'review_image/' . $fileName,
                File::get($file)
            );

            $review->profile_image = $fileName;
        }

        /*
        |--------------------------------------------------------------------------
        | REVIEW IMAGE UPDATE
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('image')) {

            // delete old review image
            if ($review->image &&
                Storage::disk('public')->exists('review_image/'.$review->image)) {
                Storage::disk('public')->delete('review_image/'.$review->image);
            }

            $file = $request->image;
            $ext = '.' . $file->getClientOriginalExtension();
            $fileName = time() . '_image_' . rand(100, 999) . $ext;

            Storage::disk('public')->put(
                'review_image/' . $fileName,
                File::get($file)
            );

            $review->image = $fileName;
        }

        // track editor (correct field)
        $review->editedby_id = auth()->id();

        $review->save();

        return redirect()
            ->back()
            ->with('success', 'Review item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $review = Review::findOrFail($id);

        if ($review->profile_image && Storage::disk('public')->exists('review_image/'.$review->profile_image)) {
            Storage::disk('public')->delete('review_image/'.$review->profile_image);
        }

        if ($review->image && Storage::disk('public')->exists('review_image/'.$review->image)) {
            Storage::disk('public')->delete('review_image/'.$review->image);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review item deleted successfully!');
    }
}
