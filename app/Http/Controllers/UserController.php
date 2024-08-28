<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');
        if ($search) {
            $users = User::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
                ->orderBy('name')
                ->where('id', '!=', '1')
                ->paginate(20)
                ->withQueryString();
        } else {
            $users = User::where('id', '!=', '1')
                ->orderBy('name')
                ->paginate(10);
        }
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'name' => ucfirst($request->name),
            'email' => ucfirst($request->email),
            'password' => Hash::make($request->password),

        ]);

        return redirect()->route('user.index')->with('success', 'user created successfully!');
    }

    public function makeadmin(User $user)
    {
        $user->timestamps = false;
        $user->is_admin = true;
        $user->save();
        return back()->with('success', $user->name . ' - Make admin successfully!');
    }

    public function removeadmin(User $user)
    {
        if ($user->id != 1) {
            $user->timestamps = false;
            $user->is_admin = false;
            $user->save();
            return back()->with('success', $user->name . ' - Remove admin successfully!');
        } else {
            return redirect()->route('user.index');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id != 1) {
            $user->delete();
            return back()->with('success',  $user->name . 'Delete user successfully!');
        } else {
            redirect()->route('user.index')->with('danger', $user->name . 'Delete user failed!');
        }
    }
}
