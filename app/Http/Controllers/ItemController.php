<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Menampilkan daftar barang pengguna (Inventori Saya).
     */
    public function index()
    {
        // Data tiruan (mock data) yang mendekati visual pada gambar
        $items = [
            // Kategori: Dapur (Coklat Muda) | Status: Tersedia (Hijau Terang)
            ['id' => 1, 'judul' => 'Rice Cooker Miyako 1.8L', 'kategori' => 'Dapur', 'status' => 'Tersedia'],
            // Kategori: Olahraga (Pink/Merah) | Status: Habis (Merah Gelap)
            ['id' => 2, 'judul' => 'Sepeda Gunung MTB 26 inch', 'kategori' => 'Olahraga', 'status' => 'Habis'],
            // Kategori: Buku & Alat Tulis (Hijau Muda/Teal) | Status: Tersedia (Hijau Terang)
            ['id' => 3, 'judul' => 'Koleksi Novel Harry Potter Lengkap', 'kategori' => 'Buku & Alat Tulis', 'status' => 'Tersedia'],
            // Kategori: Perabotan (Kuning) | Status: Reserved (Kuning Gelap/Krem)
            ['id' => 4, 'judul' => 'Meja Belajar Kayu Jati', 'kategori' => 'Perabotan', 'status' => 'Reserved'],
            // Kategori: Elektronik (Biru Muda) | Status: Tersedia (Hijau Terang)
            ['id' => 5, 'judul' => 'Kamera Digital Canon EOS 700D', 'kategori' => 'Elektronik', 'status' => 'Tersedia'],
        ];

        return view('inventory', compact('items'));
    }
}