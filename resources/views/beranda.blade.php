<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextUse | Jual Beli Barang Bekas</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* CSS Tambahan untuk gradien, jika diperlukan */
        .search-hero {
            background-image: linear-gradient(to right, #e0f2f1, #b2dfdb);
        }
    </style>
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-8">
                <a href="#" class="text-xl font-bold text-teal-600">NextUse</a>
                <div class="hidden md:flex space-x-4 text-sm font-medium text-gray-600">
                    <a href="#" class="hover:text-teal-600 transition duration-150">Browse Item</a>
                    <a href="#" class="hover:text-teal-600 transition duration-150">Post Item</a>
                    <a href="#" class="hover:text-teal-600 transition duration-150">Messages</a>
                    <a href="#" class="hover:text-teal-600 transition duration-150">Profile</a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="text-gray-500 hover:text-teal-600 transition duration-150"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg></a>
                <a href="#" class="text-gray-500 hover:text-teal-600 transition duration-150"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></a>
            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="p-6 my-6 rounded-lg search-hero border border-teal-200">
            <h1 class="text-xl font-semibold text-gray-800 mb-4">Temukan Barang yang Kamu Butuhkan!</h1>
            <p class="text-sm text-gray-600 mb-6">Berbagi dan barter barang bekas gratis dengan komunitas NextUse</p>
            <div class="flex space-x-4 items-center mb-6">
                <div class="flex-grow relative">
                    <input type="text" id="searchInput" placeholder="Cari barang yang kamu butuhkan..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <div class="hidden sm:flex space-x-2 text-sm">
                    @php $categories = ['Elektronik', 'Perabotan', 'Pakaian', 'Buku', 'OlahRaga', 'Dapur']; @endphp
                    @foreach ($categories as $cat)
                        <button class="category-filter px-3 py-1.5 rounded-full text-gray-600 border border-gray-300 hover:bg-teal-50 hover:text-teal-600 transition duration-150 @if ($loop->first) bg-teal-600 text-white border-teal-600 hover:bg-teal-700 hover:text-white @endif" data-category="{{ strtolower($cat) }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
                <button class="flex items-center space-x-2 px-4 py-2 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 transition duration-150">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    <span class="hidden sm:inline">Posting Barang</span>
                </button>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <p class="text-sm text-gray-600">24 barang ditemukan</p>
            <div class="flex space-x-4 text-sm">
                <select id="conditionFilter" class="border border-gray-300 rounded-lg px-3 py-1 focus:outline-none focus:ring-1 focus:ring-teal-500">
                    <option value="all">Semua Kondisi</option>
                    <option value="baru">Baru</option>
                    <option value="bekas">Terpakai</option>
                </select>
                <select id="sortFilter" class="border border-gray-300 rounded-lg px-3 py-1 focus:outline-none focus:ring-1 focus:ring-teal-500">
                    <option value="terbaru">Terbaru</option>
                    <option value="termurah">Termurah</option>
                    <option value="termahal">Termahal</option>
                </select>
            </div>
        </div>

        <div id="productList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @for ($i = 1; $i <= 8; $i++)
            <div class="product-item bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300 border border-gray-200" data-condition="{{ $i % 2 == 0 ? 'baru' : 'bekas' }}" data-category="{{ $i <= 4 ? 'elektronik' : 'perabotan' }}">
                <div class="relative h-48 bg-gray-100 flex items-center justify-center">
                    <span class="absolute top-2 right-2 text-xs font-semibold px-2 py-1 rounded-full bg-teal-500 text-white">Terawat</span>
                    <span class="absolute bottom-2 right-2 text-xs font-semibold px-2 py-1 rounded-full bg-green-600 text-white">Posting Barang</span>
                    <img src="{{ asset('images/product-placeholder.jpg') }}" alt="Kamera Digital Canon EOS 700D" class="w-full h-full object-cover">
                    </div>
                <div class="p-4">
                    <h3 class="text-base font-semibold text-gray-800 mb-1">Kamera Digital Canon EOS 700D {{ $i }}</h3>
                    <p class="text-sm text-gray-500 mb-2">
                        <span class="font-medium text-teal-600">Elektronik</span> | Live Now
                    </p>
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <p class="mr-3">Ahmad Ridh</p>
                        <svg class="w-4 h-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <p>Jakarta Selatan</p>
                    </div>
                </div>
            </div>
            @endfor
            </div>

    </main>

    <footer class="mt-12 py-6 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            <div class="space-x-4 mb-2">
                <a href="#" class="hover:text-teal-600">Tentang Kami</a>
                <a href="#" class="hover:text-teal-600">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-teal-600">Kebijakan Privasi</a>
                <a href="#" class="hover:text-teal-600">Hubungi Kami</a>
            </div>
            <p>&copy; 2025 NextUse. Platform berbagi dan barter barang gratis.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>