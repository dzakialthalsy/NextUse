<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Pastikan menggunakan Controller base Anda

class ItemController extends Controller
{
    /**
     * Menampilkan daftar barang pengguna.
     */
    public function index()
    {
        // Data tiruan (mock data) sesuai dengan gambar Anda
        $items = [
            ['id' => 1, 'judul' => 'Rice Cooker Miyako 1.8L', 'kategori' => 'Dapur', 'status' => 'Tersedia'],
            ['id' => 2, 'judul' => 'Sepeda Gunung MTB 26 inch', 'kategori' => 'Olahraga', 'status' => 'Habis'],
            ['id' => 3, 'judul' => 'Koleksi Novel Harry Potter Lengkap', 'kategori' => 'Buku & Alat Tulis', 'status' => 'Tersedia'],
            ['id' => 4, 'judul' => 'Meja Belajar Kayu Jati', 'kategori' => 'Perabotan', 'status' => 'Reserved'],
            ['id' => 5, 'judul' => 'Kamera Digital Canon EOS 700D', 'kategori' => 'Elektronik', 'status' => 'Tersedia'],
        ];

        return view('inventory', compact('items'));
    }
}