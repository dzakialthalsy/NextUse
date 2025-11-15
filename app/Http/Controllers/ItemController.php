<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Menampilkan daftar barang pengguna (Inventori Saya).
     */
    public function index(Request $request)
    {
        $query = Item::where('user_id', Auth::id())
            ->where('is_draft', false);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->has('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        // Filter status
        if ($request->has('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort', 'tanggal-desc');
        switch ($sortBy) {
            case 'tanggal-asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'judul-asc':
                $query->orderBy('judul', 'asc');
                break;
            case 'judul-desc':
                $query->orderBy('judul', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $items = $query->paginate(10);

        return view('inventory', compact('items'));
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($item);
    }

    /**
     * Update barang.
     */
    public function update(Request $request, $id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Elektronik,Perabotan,Pakaian,Buku & Alat Tulis,Mainan & Hobi,Olahraga,Dapur,Lainnya',
            'kondisi' => 'required|in:baru,like-new,bekas',
            'deskripsi' => 'required|string|min:30',
            'lokasi' => 'required|string|max:255',
            'status' => 'nullable|in:tersedia,reserved,habis',
            'foto_barang' => 'nullable|array|max:8',
            'foto_barang.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_barang_old' => 'nullable|array',
            'foto_barang_old.*' => 'string',
        ], [
            'judul.required' => 'Judul barang wajib diisi',
            'kategori.required' => 'Kategori wajib dipilih',
            'kondisi.required' => 'Kondisi barang wajib dipilih',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'deskripsi.min' => 'Deskripsi minimal 30 karakter',
            'lokasi.required' => 'Lokasi wajib diisi',
            'foto_barang.max' => 'Maksimal 8 foto',
            'foto_barang.*.image' => 'File harus berupa gambar',
            'foto_barang.*.max' => 'Ukuran file maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle foto upload
        $fotoPaths = $request->foto_barang_old ?? [];
        
        if ($request->hasFile('foto_barang')) {
            foreach ($request->file('foto_barang') as $foto) {
                $path = $foto->store('items', 'public');
                $fotoPaths[] = $path;
            }
        }

        // Update item
        $item->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'status' => $request->status ?? $item->status,
            'foto_barang' => $fotoPaths,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diperbarui',
            'item' => $item
        ]);
    }

    /**
     * Hapus barang.
     */
    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);
        
        // Hapus foto dari storage
        if ($item->foto_barang) {
            foreach ($item->foto_barang as $foto) {
                if (Storage::disk('public')->exists($foto)) {
                    Storage::disk('public')->delete($foto);
                }
            }
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus'
        ]);
    }

    /**
     * Update status barang (single atau bulk).
     */
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
            'status' => 'required|in:tersedia,reserved,habis',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $items = Item::where('user_id', Auth::id())
            ->whereIn('id', $request->item_ids)
            ->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah',
            'count' => $items
        ]);
    }

    /**
     * Bulk delete barang.
     */
    public function bulkDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $items = Item::where('user_id', Auth::id())
            ->whereIn('id', $request->item_ids)
            ->get();

        // Hapus foto dari storage
        foreach ($items as $item) {
            if ($item->foto_barang) {
                foreach ($item->foto_barang as $foto) {
                    if (Storage::disk('public')->exists($foto)) {
                        Storage::disk('public')->delete($foto);
                    }
                }
            }
        }

        Item::where('user_id', Auth::id())
            ->whereIn('id', $request->item_ids)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => count($items) . ' barang berhasil dihapus',
            'count' => count($items)
        ]);
    }
}