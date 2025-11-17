    <header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100 h-[64.67px]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-6 h-full flex justify-between items-center">
            <a href="#" class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-lg main-gradient flex items-center justify-center">
                    <span class="font-bold text-white text-base">N</span>
                </div>
                <span class="text-lg font-semibold text-gray-900">NextUse</span>
            </a>
            
            <nav class="hidden md:flex space-x-6 text-sm font-normal">
                @php
                    $isInventoryPage = request()->routeIs('inventory.index');
                    $isPostItemPage = request()->routeIs('post-item.create');
                    $isChatPage = request()->routeIs('chat.*');
                    $isProfilePage = request()->routeIs('profile.*');
                @endphp
                <a href="{{ route('beranda') }}" class="{{ !$isInventoryPage && !$isPostItemPage && ! $isChatPage && ! $isProfilePage ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Browse</a>
                <a href="{{ route('post-item.create') }}" class="{{ $isPostItemPage ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Post Item</a>
                <a href="{{ route('chat.index') }}" class="{{ $isChatPage ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Messages</a>
                <a href="{{ route('profile.index') }}" class="{{ $isProfilePage ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Profile</a>
            </nav>

            <div class="flex items-center space-x-3">
                <button class="relative p-2 rounded-lg hover:bg-gray-100 transition duration-150">
                    <svg class="w-5 h-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <span class="absolute top-1 right-1 block w-2 h-2 bg-red-600 rounded-full"></span>
                </button>
                <div class="w-8 h-8 rounded-full main-gradient flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
            </div>
        </div>
    </header>