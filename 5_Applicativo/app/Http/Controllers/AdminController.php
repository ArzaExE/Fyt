<?php

namespace App\Http\Controllers;


use App\Http\Requests\AdminUpdateRequest;
use App\Models\User;
use App\Models\user_roles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin', compact('users'));
    }

    public function edit(User $user) {
        $roles = ['admin', 'vendor', 'user'];
        $key = array_search($user->role->name, $roles);
        unset($roles[$key]);
        return view('templates.editUser', compact('user', 'roles'));
    }

    public function save(AdminUpdateRequest $request, User $user): RedirectResponse
    {
        $validatedData = $request->validated();

        $user->update($request->except('role'));

        if ($request->has('role')) {
            $role = user_roles::where('name', $request->role)->first();
            $user->role()->associate($role);
        }

        $user->save();

        return Redirect::route('admin')->with('success', "User {$user->username} has been successfully modified");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your account!');
        }

        DB::transaction(function() use ($user) {
            $user->forceDelete();
        });

        return redirect()->route('admin')
            ->with('success', "User {$user->username} has been successfully deleted");
    }
}
