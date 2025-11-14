<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostItemController extends Controller
{
    /**
     * Menampilkan form untuk posting barang baru.
     */
    public function create()
    {
        return view('posting-item');
    }

    /**
     * Menyimpan barang yang diposting.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Elektronik,Perabotan,Pakaian,Buku & Alat Tulis,Mainan & Hobi,Olahraga,Dapur,Lainnya',
            'kondisi' => 'required|in:baru,like-new,bekas',
            'deskripsi' => 'required|string|min:30',
            'lokasi' => 'required|string|max:255',
            'status' => 'nullable|in:tersedia,reserved,habis',
            'preferensi' => 'nullable|array',
            'preferensi.*' => 'in:giveaway,barter',
            'catatan_pengambilan' => 'nullable|string|max:1000',
            'foto_barang' => 'required|array|min:1|max:8',
            'foto_barang.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
            'setuju_kebijakan' => 'required|accepted',
        ], [
            'judul.required' => 'Judul barang wajib diisi',
            'kategori.required' => 'Kategori wajib dipilih',
            'kondisi.required' => 'Kondisi barang wajib dipilih',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'deskripsi.min' => 'Deskripsi minimal 30 karakter',
            'lokasi.required' => 'Lokasi wajib diisi',
            'foto_barang.required' => 'Minimal 1 foto wajib diunggah',
            'foto_barang.min' => 'Minimal 1 foto wajib diunggah',
            'foto_barang.max' => 'Maksimal 8 foto',
            'foto_barang.*.image' => 'File harus berupa gambar',
            'foto_barang.*.max' => 'Ukuran file maksimal 5MB',
            'setuju_kebijakan.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'setuju_kebijakan.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Upload foto
        $fotoPaths = [];
        if ($request->hasFile('foto_barang')) {
            foreach ($request->file('foto_barang') as $foto) {
                $path = $foto->store('items', 'public');
                $fotoPaths[] = $path;
            }
        }

        // Simpan item
        $item = Item::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'status' => $request->status ?? 'tersedia',
            'preferensi' => $request->preferensi ?? [],
            'catatan_pengambilan' => $request->catatan_pengambilan,
            'foto_barang' => $fotoPaths,
            'is_draft' => false,
        ]);

        return redirect()->route('inventory.index')
            ->with('success', 'Postingan berhasil diterbitkan');
    }

    /**
     * Menyimpan draft barang.
     */
    public function saveDraft(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'nullable|string|max:255',
            'kategori' => 'nullable|in:Elektronik,Perabotan,Pakaian,Buku & Alat Tulis,Mainan & Hobi,Olahraga,Dapur,Lainnya',
            'kondisi' => 'nullable|in:baru,like-new,bekas',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'status' => 'nullable|in:tersedia,reserved,habis',
            'preferensi' => 'nullable|array',
            'preferensi.*' => 'in:giveaway,barter',
            'catatan_pengambilan' => 'nullable|string|max:1000',
            'foto_barang' => 'nullable|array|max:8',
            'foto_barang.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Upload foto jika ada
        $fotoPaths = [];
        if ($request->hasFile('foto_barang')) {
            foreach ($request->file('foto_barang') as $foto) {
                $path = $foto->store('items', 'public');
                $fotoPaths[] = $path;
            }
        }

        // Simpan draft
        $item = Item::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul ?? '',
            'kategori' => $request->kategori ?? 'Lainnya',
            'kondisi' => $request->kondisi ?? 'bekas',
            'deskripsi' => $request->deskripsi ?? '',
            'lokasi' => $request->lokasi ?? '',
            'status' => $request->status ?? 'tersedia',
            'preferensi' => $request->preferensi ?? [],
            'catatan_pengambilan' => $request->catatan_pengambilan,
            'foto_barang' => $fotoPaths,
            'is_draft' => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Draft tersimpan']);
    }
}
