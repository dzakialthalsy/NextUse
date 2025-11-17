@extends('layouts.app')

@section('title', 'Profil Saya - NextUse')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-10 space-y-8">
        <div class="space-y-1">
            <h1 class="text-3xl font-semibold text-slate-900">Profil Saya</h1>
            <p class="text-sm text-slate-500">Kelola informasi pribadi dan pengaturan akun Anda.</p>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-100">
            <div class="flex flex-col gap-6 px-6 py-6 sm:flex-row sm:items-start sm:justify-between">
                <div class="flex gap-4">
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500 text-2xl font-semibold text-white">
                        {{ strtoupper(mb_substr($profile->full_name, 0, 1)) }}
                    </div>
                    <div class="space-y-1">
                        <div>
                            <p class="text-base font-semibold text-slate-900">{{ $profile->full_name }}</p>
                            <p class="text-sm text-slate-500">{{ $profile->headline ?? '@'.Str::slug($profile->full_name) }}</p>
                        </div>
                        <dl class="mt-3 space-y-2 text-sm text-slate-600">
                            @if ($profile->contact_email)
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-50 text-[10px] text-slate-500">
                                        @
                                    </span>
                                    <div>
                                        <dt class="text-xs text-slate-400">Email</dt>
                                        <dd>{{ $profile->contact_email }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if ($profile->location)
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-50 text-[10px] text-slate-500">
                                        📍
                                    </span>
                                    <div>
                                        <dt class="text-xs text-slate-400">Lokasi</dt>
                                        <dd>{{ $profile->location }}</dd>
                                    </div>
                                </div>
                            @endif
                            @if ($profile->joined_at)
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-50 text-[10px] text-slate-500">
                                        📅
                                    </span>
                                    <div>
                                        <dt class="text-xs text-slate-400">Bergabung</dt>
                                        <dd>{{ $profile->joined_at->translatedFormat('F Y') }}</dd>
                                    </div>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <a href="{{ route('profile.edit', $profile) }}"
                        class="inline-flex items-center rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Edit Profil
                    </a>
                </div>
            </div>

            <div class="border-t border-slate-100 px-6 py-5">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Statistik</p>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <p class="text-xs text-slate-500">Items Posted</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $profile->completed_deals }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <p class="text-xs text-slate-500">Items Borrowed</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $profile->followers_count }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3">
                        <p class="text-xs text-slate-500">Trades</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $profile->following_count }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div class="rounded-3xl bg-white shadow-sm ring-1 ring-slate-100">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h2 class="text-sm font-semibold text-slate-900">Aktivitas Terakhir</h2>
                    <p class="text-xs text-slate-500">Riwayat aktivitas Anda di NextUse</p>
                </div>
                <ul class="divide-y divide-slate-100 text-sm text-slate-700">
                    <li class="flex items-start gap-3 px-6 py-4">
                        <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                        <div>
                            <p>Memposting item <span class="font-semibold">"Kamera Digital Canon"</span></p>
                            <p class="text-xs text-slate-400">2 jam yang lalu</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 px-6 py-4">
                        <span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span>
                        <div>
                            <p>Meminjam <span class="font-semibold">"Buku Programming Python"</span></p>
                            <p class="text-xs text-slate-400">1 hari yang lalu</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 px-6 py-4">
                        <span class="mt-1 h-2 w-2 rounded-full bg-sky-500"></span>
                        <div>
                            <p>Menyelesaikan transaksi barter</p>
                            <p class="text-xs text-slate-400">3 hari yang lalu</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="rounded-3xl bg-white shadow-sm ring-1 ring-slate-100">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h2 class="text-sm font-semibold text-slate-900">Pengaturan</h2>
                    <p class="text-xs text-slate-500">Kelola preferensi akun Anda</p>
                </div>
                <div class="divide-y divide-slate-100 text-sm text-slate-700">
                    <button type="button" class="flex w-full items-center justify-between px-6 py-4 hover:bg-slate-50">
                        <span class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 text-xs text-slate-600">
                                🔔
                            </span>
                            Notifikasi
                        </span>
                        <span class="text-xs text-slate-400">Kelola preferensi</span>
                    </button>
                    <button type="button" class="flex w-full items-center justify-between px-6 py-4 hover:bg-slate-50">
                        <span class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-slate-50 text-xs text-slate-600">
                                🔒
                            </span>
                            Keamanan
                        </span>
                        <span class="text-xs text-slate-400">Ubah password</span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST"
                        class="flex items-center justify-between px-6 py-4 hover:bg-rose-50">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 text-sm font-semibold text-rose-600">
                            Keluar
                        </button>
                        <span class="text-xs text-rose-400">Sesi saat ini</span>
                    </form>
                </div>
            </div>

            <div class="rounded-3xl bg-white shadow-sm ring-1 ring-slate-100">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h2 class="text-sm font-semibold text-slate-900">Informasi Akun</h2>
                </div>
                <dl class="space-y-3 px-6 py-5 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Status Akun</dt>
                        <dd class="text-emerald-600 font-semibold">Aktif</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Verifikasi Email</dt>
                        <dd class="text-emerald-600 font-semibold">Terverifikasi</dd>
                    </div>
                    <div class="flex flex-col gap-3 pt-2">
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-500">Tipe Akun</dt>
                            <dd class="text-slate-700">Gratis</dd>
                        </div>
                        <button type="button"
                            class="w-full rounded-full border border-emerald-500 px-4 py-2 text-sm font-semibold text-emerald-600 hover:bg-emerald-50">
                            Upgrade ke Premium
                        </button>
                    </div>
                </dl>
            </div>
        </section>
    </div>
@endsection


