<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('developer', 0)->get();
        $roles = Role::orderBy('id','DESC')->get();
        return view('admin.roles.users',compact('roles', 'users'));
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
        // Validate incoming request
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6',
            // 'role_id'  => 'required|exists:roles,id',
        ]);

        // Create new booking
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone ?? null;
        $user->password = Hash::make($request->password);
        $user->save();

        $role = Role::findById($request->role_id);
        $rolName = $role->name;
        $user->assignRole($rolName);
 
        return redirect()->route('users.index')->with('success','User created successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     // dd($request->all());
    //     // যে user-কে আপডেট করব তাকে বের করি
    //     $user = User::findOrFail($id);

    //     // ভ্যালিডেশন
    //     $request->validate([
    //         'name'     => 'required|string|max:255',
    //         // নিজের email allow, অন্য কারওটা ডুপ্লিকেট হতে পারবে না
    //         'email'    => 'required|email|unique:users,email,' . $user->id,
    //         'phone'    => 'nullable|string|max:20',
    //         'role_id'  => 'required|exists:roles,id',

    //         // update এ password সাধারণত optional থাকে
    //         // যদি ফর্মে password_confirmation থাকে, তাহলে confirmed ব্যবহার করো
    //         'password' => 'nullable|min:6', // 'nullable|min:6|confirmed' ও করতে পারো
    //     ]);

    //     // মূল ফিল্ডগুলো আপডেট
    //     $user->role_id = $request->role_id;
    //     $user->name    = $request->name;
    //     $user->email   = $request->email;
    //     $user->phone   = $request->phone ?? null;

    //     // পাসওয়ার্ড ফিলাপ করলে তবেই আপডেট হবে
    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->password);
    //     }

    //     $user->save();

    //     // Spatie role sync
    //     $role     = Role::findById($request->role_id);
    //     $roleName = $role->name;

    //     // আগের সব role রিমুভ করে নতুন role সেট করবে
    //     $user->syncRoles([$roleName]);

    //     return redirect()
    //         ->route('users.index')
    //         ->with('success', 'User updated successfully');
    // }


    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'nullable|min:6', // যদি confirmation থাকে: 'nullable|min:6|confirmed'
        ]);

        DB::transaction(function () use ($request, $user) {

            // 1) User info update
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            // যদি users table এ role_id রাখো
            $user->role_id = (int) $request->role_id;

            // 2) Password optional update
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // 3) Spatie role sync (guard_name = web নিশ্চিত)
            $role = Role::where('id', (int) $request->role_id)
                ->where('guard_name', 'web')
                ->firstOrFail();

            $user->syncRoles([$role->name]);
        });

        // dd($user->fresh()->getRoleNames());

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // সব role detach করে দাও
        $user->syncRoles([]);          // অথবা $user->roles()->detach();

        // চাইলে permission-ও detach করতে পারো (extra safety)
        $user->syncPermissions([]);    // অথবা $user->permissions()->detach();

        // এরপর user delete
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
