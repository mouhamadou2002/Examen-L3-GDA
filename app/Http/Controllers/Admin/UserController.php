<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $clients = User::where('role', 'client')->get();
        return view('admin.users.index', compact('clients'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);
        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'Informations client modifiées.');
    }

    public function orders($id)
    {
        $user = User::findOrFail($id);
        $orders = $user->orders()->with('orderItems.product')->get();
        return view('admin.users.orders', compact('user', 'orders'));
    }
} 