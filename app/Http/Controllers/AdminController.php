<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\ContactMessage;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Sponsor;
use App\Models\Story;
use App\Models\SubscribeEmail;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data['slider_count'] = Slider::count();
        $data['story_count'] = Story::count();
        $data['sponsor_count'] = Sponsor::count();
        $data['review_count'] = Review::count();
        $data['campaign_count'] = Campaign::count();

        return view('admin.dashboard', $data);
    }

    public function translations()
    {
        return view('admin.translations.index');
    }


    public function media()
    {
        return view('admin.media.index');
    }

    public function pages()
    {
        return view('admin.pages.index');
    }

    public function subscriberList()
    {
        $subscribers = SubscribeEmail::get();
        return view('admin.subscribers', compact('subscribers'));
    }

    public function subscriberDelete($id)
    {
        $subscriber = SubscribeEmail::findOrFail($id);

        $subscriber->delete();

        return redirect()
            ->route('admin.subscriberList')
            ->with('success', 'Subscriber deleted successfully');
    }


    public function contactMessage()
    {
        $contact_message = ContactMessage::get();
        return view('admin.contact_message', compact('contact_message'));
    }

    public function contactMessageDestry($id)
    {
        $subscriber = ContactMessage::findOrFail($id);

        $subscriber->delete();

        return redirect()
            ->route('admin.contactMessage')
            ->with('success', 'Contact message deleted successfully');
    }
}
