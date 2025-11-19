<header class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100 h-[64.67px]">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-6 h-full flex justify-between items-center">
            <a href="{{ route('beranda') }}" class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-lg main-gradient flex items-center justify-center">
                    <span class="font-bold text-white text-base">N</span>
                </div>
                <span class="text-lg font-semibold text-gray-900">NextUse</span>
            </a>
            
            <nav class="hidden md:flex space-x-6 text-sm font-normal">
                @php
                    $isAdmin = session('is_admin') === true;
                @endphp
                @if($isAdmin)
                    @php
                        $isKelola = request()->routeIs('admin.mengelola-data.index');
                        $isTinjau = request()->routeIs('admin.tinjau') || request()->routeIs('admin.review.*');
                    @endphp
                    <a href="{{ route('admin.mengelola-data.index') }}" class="{{ $isKelola ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Kelola</a>
                    <a href="{{ route('admin.tinjau') }}" class="{{ $isTinjau ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Tinjau</a>
                @else
                    @php
                        $isInventoryPage = request()->routeIs('inventory.index');
                        $isPostItemPage = request()->routeIs('post-item.create');
                        $isChatPage = request()->routeIs('chat.*');
                    @endphp
                    <a href="{{ route('beranda') }}" class="{{ !$isInventoryPage && !$isPostItemPage && ! $isChatPage ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Browse</a>
                    <a href="{{ route('inventory.index') }}" class="{{ $isInventoryPage ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Inventory</a>
                    <a href="{{ route('post-item.create') }}" class="{{ $isPostItemPage ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Post Item</a>
                    <a href="{{ route('chat.index') }}" class="{{ $isChatPage ? 'text-gray-900 border-b-2 border-teal-500 font-medium' : 'text-gray-500 hover:text-gray-900' }} transition duration-150">Messages</a>
                @endif
            </nav>

            <div class="flex items-center space-x-3 relative">
                <a href="{{ route('profile.index') }}" class="w-8 h-8 rounded-full main-gradient flex items-center justify-center">
                <div id="notif-dropdown" class="hidden absolute right-0 top-12 w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-50">
                    <div class="p-3 border-b border-gray-100 text-sm font-semibold text-gray-700">Notifikasi</div>
                    <div id="notif-list" class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                        <div class="p-3 text-sm text-gray-500">Tidak ada notifikasi</div>
                    </div>
                </div>
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </a>
            </div>
        </div>
    </header>
    @push('scripts')
    @endpush