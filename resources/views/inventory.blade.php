<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventori Saya - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    {{-- Ini akan menggunakan style/script dari vite.config.js dan resources/css/app.css --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col">

<div class="max-w-7xl w-full">
    <header class="w-full text-sm mb-12">
        <nav class="flex items-center justify-between">
            <div class="flex items-center space-x-10">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold">N</div>
                <a href="#" class="font-medium text-gray-700 dark:text-gray-300">Browse</a>
                <a href="#" class="font-medium text-gray-700 dark:text-gray-300">Post Item</a>
                <a href="#" class="font-medium text-gray-700 dark:text-gray-300">Messages</a>
                <a href="#" class="font-medium text-gray-700 dark:text-gray-300">Profile</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="#" class="relative">
                    {{-- Notification Icon SVG (Placeholder) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.343 8.216 8.216 0 0 1-2.164-.784c-.39-.144-.43-.377-.1-.663.388-.344.869-.64 1.41-1.026-.067.06-.151.134-.238.223A25.488 25.488 0 0 0 12 18h-1.5a.75.75 0 0 1-.75-.75V4.75a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .75.75V17.25c0 .355.286.641.641.641a2.89 2.89 0 1 0 0-5.781 1.341 1.341 0 0 1 0-2.682h1.5" />
                    </svg>
                    {{-- Notif Dot --}}
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">3</span>
                </a>
                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                    {{-- Profile Icon SVG (Placeholder) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.723.796H4.474a.75.75 0 0 1-.723-.796Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Inventori Saya</h1>
            <button class="flex items-center space-x-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                {{-- Plus Icon SVG (Placeholder) --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Posting Barang Baru</span>
            </button>
        </div>

        <p class="text-gray-500 dark:text-[#A1A09A] mb-8">Kelola semua barang yang Anda posting.</p>

        <div class="flex space-x-4 mb-8">
            <div class="relative flex-1">
                {{-- Search Icon SVG (Placeholder) --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" placeholder="Cari barang..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-[#161615] dark:border-[#3E3E3A] dark:text-[#EDEDEC] text-sm" />
            </div>

            <div class="flex items-center space-x-3 bg-white dark:bg-[#161615] border border-gray-300 dark:border-[#3E3E3A] rounded-lg px-3 text-sm text-gray-700 dark:text-[#EDEDEC] cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                {{-- Filter Icon SVG (Placeholder) --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 dark:text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a2.25 2.25 0 1 1-4.5 0m4.5 0a2.25 2.25 0 1 0-4.5 0M18.75 12h.008v.008h-.008V12Zm-12 0h.008v.008h-.008V12Zm4.5 0h.008v.008h-.008V12Zm-12 0a2.25 2.25 0 1 0 0 4.5h15.75a2.25 2.25 0 1 0 0-4.5H3.75Z" />
                </svg>
                <span>Filter</span>
            </div>

            {{-- Filter Dropdowns --}}
            <div class="flex space-x-3">
                <select class="px-3 py-2 border border-gray-300 dark:border-[#3E3E3A] dark:bg-[#161615] rounded-lg text-sm appearance-none cursor-pointer">
                    <option>Semua Kategori</option>
                </select>
                <select class="px-3 py-2 border border-gray-300 dark:border-[#3E3E3A] dark:bg-[#161615] rounded-lg text-sm appearance-none cursor-pointer">
                    <option>Semua Status</option>
                </select>
                <div class="flex items-center border border-gray-300 dark:border-[#3E3E3A] dark:bg-[#161615] rounded-lg px-3 text-sm cursor-pointer hover:border-gray-400 dark:hover:border-gray-500">
                    {{-- Sort Icon SVG (Placeholder) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                    </svg>
                    <select class="py-2 dark:bg-[#161615] text-sm appearance-none cursor-pointer">
                        <option>Terbaru</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 dark:border-[#3E3E3A] rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#3E3E3A]">
                {{-- Table Header --}}
                <thead class="bg-gray-50 dark:bg-[#1b1b18]">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            <input type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 dark:bg-[#161615] dark:border-[#3E3E3A]">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Foto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="bg-white dark:bg-[#161615] divide-y divide-gray-200 dark:divide-[#3E3E3A]">
                    @foreach ($items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 dark:bg-[#161615] dark:border-[#3E3E3A]">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- Placeholder for Foto --}}
                                <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.322 2.322 0 0 1 5.25 7.669v5.034a2.322 2.322 0 0 1 1.577 1.494m-1.577-6.528A2.322 2.322 0 0 1 7.669 5.25h5.034a2.322 2.322 0 0 1 1.494 1.577" />
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $item['judul'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @switch($item['kategori'])
                                        @case('Dapur') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @break
                                        @case('Olahraga') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @break
                                        @case('Buku & Alat Tulis') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 @break
                                        @case('Perabotan') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @break
                                        @case('Elektronik') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @break
                                        @default bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300
                                    @endswitch
                                ">
                                    {{ $item['kategori'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $status_color = match ($item['status']) {
                                        'Tersedia' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200',
                                        'Habis' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200',
                                        'Reserved' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                    };
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status_color }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    {{-- Action/Menu Icon (Placeholder) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ml-auto">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <footer class="mt-12 text-center text-xs text-gray-500 dark:text-gray-400">
        © 2025 NextUse. Platform berbagi dan barter barang gratis.
    </footer>
</div>
</body>
</html>