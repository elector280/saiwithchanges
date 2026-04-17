<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class CustomerAuthController extends Controller
{
    public function showLogin() 
    {
        return view('customer.auth.login');
    }

  public function showRegister() 
  {
    return view('customer.auth.register');
  }

  public function register(Request $request) 
  {
    $data = $request->validate([
      'name' => ['required','string','max:255'],
      'email' => ['required','email','max:255','unique:customers,email'],
      'phone' => ['nullable','string','max:30'],
      'password' => ['required', Password::min(8)->letters()->numbers(), 'confirmed'],
    ]);

    $customer = Customer::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'phone' => $data['phone'] ?? null,
      'password' => Hash::make($data['password']),
    ]);

    Auth::guard('customer')->login($customer);

    return redirect()->route('customer.dashboard')->with('success', 'Welcome! Account created.');
  }

  
  public function login(Request $request)
  {
      $credentials = $request->validate([
          'email'    => ['required', 'email'],
          'password' => ['required', 'string'],
      ]);

      $user = User::where('email', $credentials['email'])->first();

      if (!$user) {
          return back()->withErrors(['email' => 'Email not found'])->onlyInput('email');
      }
// dd($request->all());
      // 
      // ✅ password match check (সবচেয়ে গুরুত্বপূর্ণ)
      if (!Hash::check($credentials['password'], $user->password)) {
          return back()->withErrors(['email' => 'Password mismatch (not hashed or wrong password)'])
              ->onlyInput('email');
      }
// dd($request->all(), 1);
      // ✅ এখন attempt কাজ করার কথা
      Auth::guard('web')->login($user, $request->boolean('remember'));
      $request->session()->regenerate();

      return redirect()->route('customer.dashboard')->with('success', 'Login successful.');
  }


  public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $notification = array(
            'message' => 'User Login Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->intended(RouteServiceProvider::HOME)->with($notification);
    }

  public function logout(Request $request) 
  {
    Auth::guard('customer')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('customer.login')->with('success', 'Logged out.');
  }

  
  public function dashboard() 
  {
    $customer = Auth::guard('customer')->user();
    return view('customer.dashboard', compact('customer'));
  }

  public function profileUpdate(Request $request)
  {
    // dd($request->all());

    $user = Auth::user();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone_number = $request->phone_number;
    $user->address = $request->address;
    $user->save();

    return back()->with('success', 'Profile updated successfully.');
  }
  public function passUpdate(Request $request)
{
    $request->validate([
        'current_password' => ['required', 'string'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = Auth::user(); // web/customer যেটাই হোক, তুমি এখন web use করছো

    if (!$user) {
        return back()->with('error', 'Please login first.');
    }

    // ❌ old password mismatch
    if (!Hash::check($request->current_password, $user->password)) {
        return back()
            ->withErrors([
                'current_password' => 'Your current password does not match our records.',
            ])
            ->withInput();
    }

    // ❌ same password prevent (optional)
    if (Hash::check($request->password, $user->password)) {
        return back()
            ->withErrors([
                'password' => 'New password cannot be the same as the current password.',
            ])
            ->withInput();
    }

    // ✅ update password
    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', 'Password updated successfully.');
}
}
