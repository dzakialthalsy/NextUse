<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventori Saya - NextUse</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Mengatur background body secara keseluruhan */
        body {
            background-color: #fcfcfc; 
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0; 
        }
        
        /* Container utama untuk membatasi lebar konten (diperkirakan 1100px) */
        .main-container {
            width: 100%;
            max-width: 1100px;
            padding: 24px 32px; /* Padding sisi dan atas/bawah */
            min-height: 100vh;
        }

        /* Nav Link Styling */
        .nav-link {
            font-size: 15px;
            color: #4b5563; /* Gray 600 */
        }
        .nav-link.active {
            font-weight: 600;
            color: #111827; /* Gray 900 */
        }

        /* FILTER AND SEARCH BAR LAYOUT */
        .search-input-wrapper {
            /* Membuat Search Bar mengambil sisa ruang */
            flex-grow: 1;
        }
        .filter-buttons {
            /* Group semua tombol filter/sort */
            display: flex;
            gap: 8px; /* Spasi antar tombol filter */
        }
        .filter-element {
            /* Style dasar untuk setiap elemen filter/sort */
            height: 38px;
            border: 1px solid #d1d5db; /* border gray 300 */
            border-radius: 6px; /* rounded-md */
            background-color: white;
            display: flex;
            align-items: center;
            padding: 0 10px; 
            font-size: 14px;
            color: #4b5563; /* text-gray-600 */
            cursor: pointer;
            position: relative;
        }
        .filter-element:hover {
            border-color: #9ca3af; /* hover border color */
        }
        .filter-element select {
            border: none;
            outline: none;
            padding: 0;
            background-color: transparent;
            cursor: pointer;
            /* Menyembunyikan default arrow agar menggunakan SVG custom */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .filter-element .arrow-icon {
            margin-left: 4px;
            color: #9ca3af; /* gray-400 */
        }
        .filter-element .sort-icon {
            margin-right: 4px;
            color: #9ca3af; /* gray-400 */
        }

        /* BADGE AND ICON BOX COLORS (Disesuaikan agar sangat mirip gambar) */
        .badge {
            padding: 3px 10px; 
            border-radius: 9999px;
            font-size: 12px; 
            font-weight: 500;
            line-height: 1;
            white-space: nowrap;
        }
        .badge-dapur { background-color: #e5f5f7; color: #007c91; }
        .badge-olahraga { background-color: #f9e2e7; color: #e54d72; }
        .badge-buku { background-color: #e3f9ed; color: #15803d; }
        .badge-perabotan { background-color: #f9f5e7; color: #a16207; }
        .badge-elektronik { background-color: #e6f1fb; color: #1d4ed8; }

        /* STATUS COLORS */
        .status-tersedia { background-color: #ecfdf5; color: #059669; }
        .status-habis { background-color: #fee2e2; color: #ef4444; }
        .status-reserved { background-color: #fffbeb; color: #f59e0b; }
        
        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon-box-olahraga { background-color: #fef0f7; color: #f43f80; }
        .icon-box-buku { background-color: #e9f7f4; color: #0f766e; }
        .icon-box-perabotan { background-color: #fffaf0; color: #92400e; }
        .icon-box-elektronik { background-color: #eff6ff; color: #2563eb; }
        .icon-box-dapur { background-color: #ecfdf5; color: #059669; }

        /* Action Dropdown */
        .action-dropdown {
            position: relative;
        }
        .action-menu {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 4px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            min-width: 150px;
            z-index: 10;
            display: none;
        }
        .action-menu.show {
            display: block;
        }
        .action-menu-item {
            padding: 8px 12px;
            font-size: 14px;
            color: #374151;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .action-menu-item:hover {
            background-color: #f3f4f6;
        }
        .action-menu-item.danger {
            color: #ef4444;
        }
        .action-menu-item.danger:hover {
            background-color: #fee2e2;
        }

        /* Bulk Actions Bar */
        .bulk-actions-bar {
            display: none;
            padding: 12px 16px;
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            align-items: center;
            gap: 12px;
        }
        .bulk-actions-bar.show {
            display: flex;
        }

        /* Empty State */
        .empty-state {
            padding: 48px 24px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-[#fcfcfc] text-[#1b1b18] min-h-screen">
<div class="main-container mx-auto">
    
    <header class="w-full mb-10">
        <nav class="flex items-center justify-between">
            {{-- Logo dan Nav Links --}}
            <div class="flex items-center space-x-8">
                <a href="#" class="flex items-center space-x-2 text-xl font-semibold">
                    {{-- Logo N --}}
                    <div class="w-6 h-6 bg-[#10b981] rounded-md flex items-center justify-center text-white text-xs font-medium">N</div>
                    <span class="text-gray-900">NextUse</span>
                </a>
                <a href="{{ route('beranda') }}" class="nav-link">Browse</a>
                <a href="{{ route('post-item.create') }}" class="nav-link">Post Item</a>
                <a href="#" class="nav-link">Messages</a>
                <a href="{{ route('inventory.index') }}" class="nav-link active">Profile</a>
            </div>

            {{-- Ikon Notifikasi dan Profil --}}
            <div class="flex items-center space-x-4">
                <a href="#" class="relative p-1">
                    {{-- Bell Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.343 9.49 9.49 0 0 1-3.284.975m-3.921-2.923a1.5 1.5 0 0 0-1.5-1.5H9.75v-2.25m4.5-12a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 .75-.75Zm3.75 12a1.5 1.5 0 0 0-3 0v4.5a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0 1.5 0Z" />
                    </svg>
                    {{-- Notification Badge --}}
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center h-4 w-4 text-xs font-medium leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full">0</span>
                </a>
                <div class="w-8 h-8 rounded-full bg-[#10b981] flex items-center justify-center text-white cursor-pointer">
                    {{-- Profile Icon (solid) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.723.796H4.474a.75.75 0 0 1-.723-.796Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </nav>
    </header>

    <main class="w-full">
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Inventori Saya</h1>
                <p class="text-gray-500 mt-2 text-base">Kelola semua barang yang Anda posting.</p>
            </div>
            
            <a href="{{ route('post-item.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-[#10b981] hover:bg-green-700 text-white rounded-lg font-medium transition-colors shadow-md text-sm">
                {{-- Plus Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Posting Barang Baru</span>
            </a>
        </div>


        <form method="GET" action="{{ route('inventory.index') }}" id="filterForm">
            <div class="flex items-center space-x-3 mb-6">
                {{-- Search Input (Mengambil sisa lebar yang tersedia) --}}
                <div class="search-input-wrapper relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-gray-300 focus:border-gray-300 text-sm placeholder-gray-400 h-10" id="searchInput" />
                </div>

                {{-- Filter Group (Disatukan di sini) --}}
                <div class="filter-buttons">
                    {{-- Filter Icon Button (Filter utama) --}}
                    <div class="filter-element w-10 h-10 p-0 flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a2.25 2.25 0 1 1-4.5 0m4.5 0a2.25 2.25 0 1 0-4.5 0M18.75 12h.008v.008h-.008V12Zm-12 0h.008v.008h-.008V12Zm4.5 0h.008v.008h-.008V12Zm-12 0a2.25 2.25 0 1 0 0 4.5h15.75a2.25 2.25 0 1 0 0-4.5H3.75Z" />
                        </svg>
                    </div>

                    {{-- Dropdown 1: Kategori --}}
                    <div class="filter-dropdown-wrapper filter-element">
                        <select name="kategori" class="pl-0 pr-5 text-gray-700 filter-select" id="kategoriSelect">
                            <option value="semua" {{ request('kategori') == 'semua' || !request('kategori') ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="Elektronik" {{ request('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="Perabotan" {{ request('kategori') == 'Perabotan' ? 'selected' : '' }}>Perabotan</option>
                            <option value="Pakaian" {{ request('kategori') == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                            <option value="Buku & Alat Tulis" {{ request('kategori') == 'Buku & Alat Tulis' ? 'selected' : '' }}>Buku & Alat Tulis</option>
                            <option value="Mainan & Hobi" {{ request('kategori') == 'Mainan & Hobi' ? 'selected' : '' }}>Mainan & Hobi</option>
                            <option value="Olahraga" {{ request('kategori') == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                            <option value="Dapur" {{ request('kategori') == 'Dapur' ? 'selected' : '' }}>Dapur</option>
                            <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="arrow-icon w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    
                    {{-- Dropdown 2: Status --}}
                    <div class="filter-dropdown-wrapper filter-element">
                        <select name="status" class="pl-0 pr-5 text-gray-700 filter-select" id="statusSelect">
                            <option value="semua" {{ request('status') == 'semua' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                            <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="arrow-icon w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>

                    {{-- Dropdown 3: Sort --}}
                    <div class="filter-dropdown-wrapper filter-element">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="sort-icon w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                        </svg>
                        <select name="sort" class="pl-0 pr-5 text-gray-700 filter-select" id="sortSelect">
                            <option value="tanggal-desc" {{ request('sort') == 'tanggal-desc' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                            <option value="tanggal-asc" {{ request('sort') == 'tanggal-asc' ? 'selected' : '' }}>Terlama</option>
                            <option value="judul-asc" {{ request('sort') == 'judul-asc' ? 'selected' : '' }}>Judul A-Z</option>
                            <option value="judul-desc" {{ request('sort') == 'judul-desc' ? 'selected' : '' }}>Judul Z-A</option>
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="arrow-icon w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
            </div>
        </form>

        {{-- Bulk Actions Bar --}}
        <div class="bulk-actions-bar" id="bulkActionsBar">
            <span class="text-sm text-gray-700" id="selectedCount">0 item dipilih</span>
            <select id="bulkStatusSelect" class="px-3 py-1 border border-gray-300 rounded text-sm">
                <option value="">Ubah Status</option>
                <option value="tersedia">Tersedia</option>
                <option value="reserved">Reserved</option>
                <option value="habis">Habis</option>
            </select>
            <button type="button" id="bulkStatusBtn" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Terapkan</button>
            <button type="button" id="bulkDeleteBtn" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
            <button type="button" id="clearSelectionBtn" class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Batal</button>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm bg-white">
            @if($items->count() > 0)
                <table class="min-w-full divide-y divide-gray-100">
                    {{-- Table Header --}}
                    <thead class="bg-gray-50 text-gray-500 font-medium text-sm">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left w-1/12">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-green-500 shadow-sm focus:ring-green-500">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left w-1/12">Foto</th>
                            <th scope="col" class="px-6 py-3 text-left w-4/12">Judul</th>
                            <th scope="col" class="px-6 py-3 text-left w-2/12">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left w-2/12">Status</th>
                            <th scope="col" class="px-6 py-3 text-right w-1/12">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-100 text-gray-900 text-sm">
                        @foreach ($items as $item)
                            @php
                                $category_class = match ($item->kategori) {
                                    'Dapur' => 'badge-dapur',
                                    'Olahraga' => 'badge-olahraga',
                                    'Buku & Alat Tulis' => 'badge-buku',
                                    'Perabotan' => 'badge-perabotan',
                                    'Elektronik' => 'badge-elektronik',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                                $status_lower = strtolower($item->status);
                                $status_display = match ($status_lower) {
                                    'tersedia' => 'Tersedia',
                                    'reserved' => 'Reserved',
                                    'habis' => 'Habis',
                                    default => ucfirst($item->status),
                                };
                                $status_class = match ($status_lower) {
                                    'tersedia' => 'status-tersedia',
                                    'habis' => 'status-habis',
                                    'reserved' => 'status-reserved',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                                $icon_box_class = match ($item->kategori) {
                                    'Dapur' => 'icon-box-dapur',
                                    'Olahraga' => 'icon-box-olahraga',
                                    'Buku & Alat Tulis' => 'icon-box-buku',
                                    'Perabotan' => 'icon-box-perabotan',
                                    'Elektronik' => 'icon-box-elektronik',
                                    default => 'bg-gray-100 text-gray-500',
                                };
                                $foto_barang = is_array($item->foto_barang) && count($item->foto_barang) > 0 ? $item->foto_barang[0] : null;
                            @endphp

                            <tr class="hover:bg-gray-50">
                                {{-- Checkbox --}}
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <input type="checkbox" class="item-checkbox rounded border-gray-300 text-green-500 shadow-sm focus:ring-green-500" value="{{ $item->id }}" data-item-id="{{ $item->id }}">
                                </td>

                                {{-- Foto --}}
                                <td class="px-6 py-3 whitespace-nowrap">
                                    @if($foto_barang)
                                        <img src="{{ asset('storage/' . $foto_barang) }}" alt="{{ $item->judul }}" class="w-10 h-10 object-cover rounded">
                                    @else
                                        <div class="icon-box {{ $icon_box_class }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                <path d="M7.494 2.378A.75.75 0 0 1 8.25 3v1.5H15V3a.75.75 0 0 1 .756-.622L20.5 4.5l-2.072 2.392L18 8.169V20.25a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V8.169l-.428-1.277L3.5 4.5l5.072-2.122Z" />
                                                <path fill-rule="evenodd" d="M11.25 6.75a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V7.5a.75.75 0 0 1 .75-.75Zm3.75 0a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V7.5a.75.75 0 0 1 .75-.75Zm-7.5 0a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V7.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                {{-- Judul --}}
                                <td class="px-6 py-3 whitespace-nowrap font-medium">
                                    {{ $item->judul }}
                                </td>

                                {{-- Kategori Badge --}}
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="badge {{ $category_class }}">
                                        {{ $item->kategori }}
                                    </span>
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <span class="badge {{ $status_class }}">
                                        {{ $status_display }}
                                    </span>
                                </td>

                                {{-- Aksi Menu --}}
                                <td class="px-6 py-3 whitespace-nowrap text-right">
                                    <div class="action-dropdown">
                                        <button type="button" class="action-toggle inline-block text-gray-500 hover:text-gray-700" data-item-id="{{ $item->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-auto">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                            </svg>
                                        </button>
                                        <div class="action-menu" id="actionMenu{{ $item->id }}">
                                            <div class="action-menu-item" onclick="editItem({{ $item->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21h-4.5A2.25 2.25 0 0 1 9 18.75V14.25m9 0a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25h-4.5A2.25 2.25 0 0 0 9 3.75v4.5m9 0H9" />
                                                </svg>
                                                Edit
                                            </div>
                                            <div class="action-menu-item danger" onclick="deleteItem({{ $item->id }}, '{{ addslashes($item->judul) }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                                Hapus
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $items->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 mx-auto mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada barang</h3>
                    <p class="text-gray-500 mb-4">Anda belum memposting barang apapun.</p>
                    <a href="{{ route('post-item.create') }}" class="inline-flex items-center px-4 py-2 bg-[#10b981] hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Posting Barang Pertama
                    </a>
                </div>
            @endif
        </div>
    </main>

    <footer class="mt-8 mb-4 w-full text-center text-xs text-gray-500">
        © 2025 NextUse. Platform berbagi dan barter barang gratis.
    </footer>
</div>

<script>
    // Search with debounce
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    // Filter change handler
    document.querySelectorAll('.filter-select').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Select All checkbox
    const selectAll = document.getElementById('selectAll');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionsBar();
        });
    }

    // Individual checkbox handler
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBulkActionsBar();
        });
    });

    function updateSelectAllState() {
        const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
        if (selectAll) {
            selectAll.checked = allChecked;
            selectAll.indeterminate = someChecked && !allChecked;
        }
    }

    function updateBulkActionsBar() {
        const selected = Array.from(itemCheckboxes).filter(cb => cb.checked);
        const bulkBar = document.getElementById('bulkActionsBar');
        const selectedCount = document.getElementById('selectedCount');
        
        if (selected.length > 0) {
            bulkBar.classList.add('show');
            selectedCount.textContent = `${selected.length} item dipilih`;
        } else {
            bulkBar.classList.remove('show');
        }
    }

    // Action menu toggle
    document.querySelectorAll('.action-toggle').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const itemId = this.getAttribute('data-item-id');
            const menu = document.getElementById('actionMenu' + itemId);
            
            // Close all other menus
            document.querySelectorAll('.action-menu').forEach(m => {
                if (m.id !== 'actionMenu' + itemId) {
                    m.classList.remove('show');
                }
            });
            
            menu.classList.toggle('show');
        });
    });

    // Close menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-dropdown')) {
            document.querySelectorAll('.action-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // Bulk status change
    document.getElementById('bulkStatusBtn').addEventListener('click', function() {
        const selected = Array.from(itemCheckboxes).filter(cb => cb.checked).map(cb => cb.value);
        const status = document.getElementById('bulkStatusSelect').value;
        
        if (selected.length === 0) {
            alert('Pilih minimal satu item');
            return;
        }
        
        if (!status) {
            alert('Pilih status terlebih dahulu');
            return;
        }
        
        if (confirm(`Ubah status ${selected.length} item menjadi ${status}?`)) {
            fetch('{{ route("items.update-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    item_ids: selected,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal mengubah status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }
    });

    // Bulk delete
    document.getElementById('bulkDeleteBtn').addEventListener('click', function() {
        const selected = Array.from(itemCheckboxes).filter(cb => cb.checked).map(cb => cb.value);
        
        if (selected.length === 0) {
            alert('Pilih minimal satu item');
            return;
        }
        
        if (confirm(`Hapus ${selected.length} item yang dipilih?`)) {
            fetch('{{ route("items.bulk-delete") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    item_ids: selected
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal menghapus item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }
    });

    // Clear selection
    document.getElementById('clearSelectionBtn').addEventListener('click', function() {
        itemCheckboxes.forEach(cb => cb.checked = false);
        if (selectAll) selectAll.checked = false;
        updateBulkActionsBar();
    });

    // Edit item
    function editItem(id) {
        // Close menu
        document.querySelectorAll('.action-menu').forEach(menu => {
            menu.classList.remove('show');
        });
        
        // Fetch item data
        fetch(`{{ url('/items') }}/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                // Redirect to edit page or open modal
                // For now, we'll just show an alert - you can implement modal later
                alert('Fitur edit akan segera tersedia. Item ID: ' + id);
                // You can redirect to edit page: window.location.href = `/items/${id}/edit`;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data item');
            });
    }

    // Delete item
    function deleteItem(id, judul) {
        // Close menu
        document.querySelectorAll('.action-menu').forEach(menu => {
            menu.classList.remove('show');
        });
        
        if (confirm(`Hapus barang "${judul}"?`)) {
            fetch(`{{ url('/items') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal menghapus item');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
            });
        }
    }
</script>
</body>
</html>