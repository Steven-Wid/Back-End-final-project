<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:40'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/@gmail\.com$/'],
            'password' => ['required', 'confirmed', 'min:6', 'max:12'],
            'phone'    => ['required', 'string', 'regex:/^08/'],
        ], [
            'email.regex'   => 'Email harus menggunakan @gmail.com',
            'phone.regex'   => 'Nomor HP harus diawali dengan 08',
            'name.min'      => 'Nama minimal 3 huruf',
            'name.max'      => 'Nama maksimal 40 huruf',
            'password.min'  => 'Password minimal 6 huruf',
            'password.max'  => 'Password maksimal 12 huruf',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'role'     => 'user',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('user.products.index');
    }
}
