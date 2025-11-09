<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrasiController extends Controller
{
    public function index()
    {
        // Tampilkan view registrasi
        return view('registrasi');
    }
}
