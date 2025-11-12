<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login organisasi.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Proses autentikasi organisasi.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email:rfc,dns', 'max:255'],
                'password' => ['required', 'string'],
            ],
            [],
            [
                'email' => 'email organisasi',
                'password' => 'password',
            ]
        );

        $organization = Organization::where('email', $credentials['email'])->first();

        if (! $organization || ! Hash::check($credentials['password'], $organization->password)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password tidak sesuai.',
            ]);
        }

        $request->session()->regenerate();
        $request->session()->put('organization_id', $organization->id);
        $request->session()->put('organization_name', $organization->organization_name);

        return redirect()
            ->intended('/')
            ->with('status', 'Berhasil masuk sebagai '.$organization->organization_name.'.');
    }

    /**
     * Logout dari sesi organisasi.
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget([
            'organization_id',
            'organization_name',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'Anda telah keluar dari akun organisasi.');
    }
}
