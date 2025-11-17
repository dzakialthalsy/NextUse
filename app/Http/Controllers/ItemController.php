<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index(Request $request)
    {
<<<<<<< HEAD
        $organizationId = $request->session()->get('organization_id');
        
        if (!$organizationId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

=======
        if (!$request->session()->has('organization_id')) {
            return redirect()->route('login');
        }
        
        $organizationId = $request->session()->get('organization_id');
>>>>>>> 3cd9c03 (Normalize line endings)
        $query = Item::where('organization_id', $organizationId)
            ->where('is_draft', false);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->has('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

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

<<<<<<< HEAD
    /**
     * Menampilkan form edit barang.
     */
    public function edit(Request $request, $id)
    {
        $organizationId = $request->session()->get('organization_id');
        
        if (!$organizationId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

=======
    public function edit(Request $request, $id)
    {
        if (!$request->session()->has('organization_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $organizationId = $request->session()->get('organization_id');
>>>>>>> 3cd9c03 (Normalize line endings)
        $item = Item::where('organization_id', $organizationId)->findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
<<<<<<< HEAD
        $organizationId = $request->session()->get('organization_id');
        
        if (!$organizationId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

=======
        if (!$request->session()->has('organization_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $organizationId = $request->session()->get('organization_id');
>>>>>>> 3cd9c03 (Normalize line endings)
        $item = Item::where('organization_id', $organizationId)->findOrFail($id);

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
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $fotoPaths = $request->foto_barang_old ?? [];
        if ($request->hasFile('foto_barang')) {
            foreach ($request->file('foto_barang') as $foto) {
                $path = $foto->store('items', 'public');
                $fotoPaths[] = $path;
            }
        }

        $item->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'status' => $request->status ?? $item->status,
            'foto_barang' => $fotoPaths,
        ]);

        return response()->json(['success' => true, 'message' => 'Barang berhasil diperbarui', 'item' => $item]);
    }

<<<<<<< HEAD
    /**
     * Hapus barang.
     */
    public function destroy(Request $request, $id)
    {
        $organizationId = $request->session()->get('organization_id');
        
        if (!$organizationId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

=======
    public function destroy(Request $request, $id)
    {
        if (!$request->session()->has('organization_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $organizationId = $request->session()->get('organization_id');
>>>>>>> 3cd9c03 (Normalize line endings)
        $item = Item::where('organization_id', $organizationId)->findOrFail($id);
        
        if ($item->foto_barang) {
            foreach ($item->foto_barang as $foto) {
                if (Storage::disk('public')->exists($foto)) {
                    Storage::disk('public')->delete($foto);
                }
            }
        }

        $item->delete();
        return response()->json(['success' => true, 'message' => 'Barang berhasil dihapus']);
    }

    public function updateStatus(Request $request)
    {
        if (!$request->session()->has('organization_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $validator = Validator::make($request->all(), [
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
            'status' => 'required|in:tersedia,reserved,habis',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $organizationId = $request->session()->get('organization_id');
<<<<<<< HEAD
        
        if (!$organizationId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

=======
>>>>>>> 3cd9c03 (Normalize line endings)
        $items = Item::where('organization_id', $organizationId)
            ->whereIn('id', $request->item_ids)
            ->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diubah', 'count' => $items]);
    }

    public function bulkDestroy(Request $request)
    {
        if (!$request->session()->has('organization_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $validator = Validator::make($request->all(), [
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $organizationId = $request->session()->get('organization_id');
<<<<<<< HEAD
        
        if (!$organizationId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

=======
>>>>>>> 3cd9c03 (Normalize line endings)
        $items = Item::where('organization_id', $organizationId)
            ->whereIn('id', $request->item_ids)
            ->get();

        foreach ($items as $item) {
            if ($item->foto_barang) {
                foreach ($item->foto_barang as $foto) {
                    if (Storage::disk('public')->exists($foto)) {
                        Storage::disk('public')->delete($foto);
                    }
                }
            }
        }

        Item::where('organization_id', $organizationId)
            ->whereIn('id', $request->item_ids)
            ->delete();

        return response()->json(['success' => true, 'message' => count($items) . ' barang berhasil dihapus', 'count' => count($items)]);
    }
}
