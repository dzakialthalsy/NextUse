<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('organization_id')) {
            return redirect()->route('login');
        }
        
        $organizationId = $request->session()->get('organization_id');
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
}