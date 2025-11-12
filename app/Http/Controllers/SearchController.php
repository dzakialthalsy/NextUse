<?php

namespace App\Http\Controllers;

use App\Support\ProductCatalog;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $category = $request->query('category');
        $condition = $request->query('condition');

        $products = ProductCatalog::filter($query, $category, $condition);

        return view('beranda', [
            'products' => $products,
            'categories' => ProductCatalog::categories(),
            'searchQuery' => $query,
            'selectedCategory' => $category,
            'selectedCondition' => $condition,
        ]);
    }
}

