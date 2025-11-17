<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostItemController extends Controller
{
    /**
     * Menampilkan form untuk posting barang baru.
     */
    public function create(Request $request)
    {
        if (!$request->session()->has('organization_id')) {
            return redirect()->route('login');
        }
        
        return view('posting-item');
    }

    /**
     * Menyimpan barang yang diposting.
     */
    public function store(Request $request)
    {
        // Pastikan organization_id ada di session
        $organizationId = $request->session()->get('organization_id');
        if (empty($organizationId) || !is_numeric($organizationId)) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Anda harus login terlebih dahulu.']);
        }
        
        // Convert ke integer untuk memastikan tipe data benar
        $organizationId = (int) $organizationId;
        
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
                if ($foto->isValid()) {
                    $path = $foto->store('items', 'public');
                    $fotoPaths[] = $path;
                }
            }
        }

        if (empty($fotoPaths)) {
            return back()
                ->withErrors(['foto_barang' => 'Minimal 1 foto wajib diunggah dan valid'])
                ->withInput();
        }

        $preferensi = null;
        if ($request->has('preferensi') && is_array($request->preferensi) && count($request->preferensi) > 0) {
            $preferensi = $request->preferensi;
        }

        $organizationId = (int) $request->session()->get('organization_id');
        if ($organizationId <= 0) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Session tidak valid. Silakan login kembali.']);
        }

        $item = new Item();
        $item->organization_id = $organizationId;
        $item->judul = $request->judul;
        $item->kategori = $request->kategori;
        $item->kondisi = $request->kondisi;
        $item->deskripsi = $request->deskripsi;
        $item->lokasi = $request->lokasi;
        $item->status = $request->status ?? 'tersedia';
        $item->preferensi = $preferensi;
        $item->catatan_pengambilan = $request->catatan_pengambilan;
        $item->foto_barang = $fotoPaths;
        $item->is_draft = false;
        $item->save();

        return redirect()->route('inventory.index')
            ->with('success', 'Postingan berhasil diterbitkan');
    }

    /**
     * Menyimpan draft barang.
     */
    public function saveDraft(Request $request)
    {
        // Pastikan organization_id ada di session
        $organizationId = $request->session()->get('organization_id');
        if (empty($organizationId) || !is_numeric($organizationId)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        // Convert ke integer untuk memastikan tipe data benar
        $organizationId = (int) $organizationId;
        
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
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Upload foto jika ada
        $fotoPaths = [];
        if ($request->hasFile('foto_barang')) {
            foreach ($request->file('foto_barang') as $foto) {
                if ($foto->isValid()) {
                    $path = $foto->store('items', 'public');
                    $fotoPaths[] = $path;
                }
            }
        }

        $preferensi = null;
        if ($request->has('preferensi') && is_array($request->preferensi) && count($request->preferensi) > 0) {
            $preferensi = $request->preferensi;
        }

        $organizationId = (int) $request->session()->get('organization_id');
        if ($organizationId <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Session tidak valid. Silakan login kembali.'
            ], 401);
        }

        $item = new Item();
        $item->organization_id = $organizationId;
        $item->judul = $request->judul ?? '';
        $item->kategori = $request->kategori ?? 'Lainnya';
        $item->kondisi = $request->kondisi ?? 'bekas';
        $item->deskripsi = $request->deskripsi ?? '';
        $item->lokasi = $request->lokasi ?? '';
        $item->status = $request->status ?? 'tersedia';
        $item->preferensi = $preferensi;
        $item->catatan_pengambilan = $request->catatan_pengambilan;
        $item->foto_barang = $fotoPaths;
        $item->is_draft = true;
        $item->save();

        return response()->json(['success' => true, 'message' => 'Draft tersimpan']);
    }
}
