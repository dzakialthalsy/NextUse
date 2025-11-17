<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MengelolaDataBarangController extends Controller
{
    /**
     * Tampilkan dashboard pengelolaan data pengguna & barang.
     */
    public function index(Request $request)
    {
        $searchUser = $request->query('search_user');
        $searchItem = $request->query('search_item');

        $usersQuery = Organization::query();
        if ($searchUser) {
            $usersQuery->where(function ($query) use ($searchUser) {
                $query->where('organization_name', 'like', "%{$searchUser}%")
                    ->orWhere('email', 'like', "%{$searchUser}%")
                    ->orWhere('organization_type', 'like', "%{$searchUser}%");
            });
        }

        $itemsQuery = Item::with('organization')->where('is_draft', false);
        if ($searchItem) {
            $itemsQuery->where(function ($query) use ($searchItem) {
                $query->where('judul', 'like', "%{$searchItem}%")
                    ->orWhere('kategori', 'like', "%{$searchItem}%")
                    ->orWhere('lokasi', 'like', "%{$searchItem}%");
            });
        }

        $users = $usersQuery->orderByDesc('created_at')->paginate(8, ['*'], 'users_page')->withQueryString();
        $items = $itemsQuery->orderByDesc('created_at')->paginate(8, ['*'], 'items_page')->withQueryString();

        return view('admin.mengelola-data-barang', [
            'users' => $users,
            'items' => $items,
            'stats' => [
                'total_users' => Organization::count(),
                'total_items' => Item::where('is_draft', false)->count(),
                'need_review' => Item::where('status', 'reserved')->count(),
            ],
        ]);
    }

    /**
     * Hapus data organisasi.
     */
    public function destroyUser(Organization $organization): RedirectResponse
    {
        $organization->delete();

        return back()->with('success', 'Data pengguna berhasil dihapus.');
    }

    /**
     * Hapus data barang.
     */
    public function destroyItem(Item $item): RedirectResponse
    {
        $item->delete();

        return back()->with('success', 'Data barang berhasil dihapus.');
    }
}

