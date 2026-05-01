<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NewsletterWelcomeMail;
use App\Models\SubscribeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SubscribeEmailController extends Controller
{
   public function subscribe(Request $request)
{
    $data = $request->validate([
        'email' => ['required', 'email:rfc,dns', 'max:255'],
    ]);

    $subscriber = SubscribeEmail::firstOrNew(['email' => $data['email']]);

    if ($subscriber->exists && $subscriber->is_subscribed) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'You are already subscribed.'], 200);
        }
        return back()->with('success', 'You are already subscribed.');
    }

    $subscriber->is_subscribed = true;
    $subscriber->unsubscribe_token = Str::random(64);
    $subscriber->subscribed_at = now();
    $subscriber->unsubscribed_at = null;
    $subscriber->save();

    Mail::to($subscriber->email)->send(new NewsletterWelcomeMail($subscriber));

    if ($request->expectsJson()) {
        return response()->json(['message' => "You’ve been subscribed! Please check your email."], 200);
    }


    return back()->with('success', "You’ve been subscribed! Please check your email.");
}



    public function unsubscribe(string $token)
    {
        $subscriber = SubscribeEmail::where('unsubscribe_token', $token)->firstOrFail();

        if (!$subscriber->is_subscribed) {
            return view('emails.unsubscribed', [
                'message' => 'You are already unsubscribed.'
            ]);
        }

        $subscriber->update([
            'is_subscribed' => false,
            'unsubscribed_at' => now(),
        ]);

        return view('emails.unsubscribed', [
            'message' => 'You have been unsubscribed successfully.'
        ]);
    }
}
