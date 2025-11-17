@extends('layouts.app')

@section('title', 'Chat - NextUse')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
        <div class="flex flex-col gap-2 text-center">
            <p class="text-xs uppercase tracking-[0.35em] text-emerald-500 font-semibold">NextUse Connect</p>
            <h1 class="text-3xl font-bold text-slate-900">Ruang Chat Barang Bekas</h1>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="rounded-3xl border border-slate-100 bg-white p-3 shadow-lg shadow-emerald-50">
            <div class="flex flex-wrap items-center justify-center gap-2">
                @php
                    $filters = [
                        ['label' => 'Semua Chat', 'count' => $messages->count(), 'active' => true],
                        ['label' => 'Belum Dibaca', 'count' => $messages->where('is_owner', false)->count()],
                        ['label' => 'Arsip', 'count' => 12],
                    ];
                @endphp
                @foreach ($filters as $filter)
                    <button type="button"
                        class="filter-pill inline-flex items-center gap-2 rounded-full px-5 py-2 text-sm font-medium transition
                        {{ $filter['active'] ?? false ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                        <span>{{ $filter['label'] }}</span>
                    </button>
                    <span class="text-xs font-semibold text-slate-400">{{ $filter['count'] }}</span>
                @endforeach
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[320px_minmax(0,1fr)]">
            <aside class="rounded-3xl bg-white shadow-lg shadow-emerald-50 ring-1 ring-slate-100 flex flex-col">
                <div class="border-b border-slate-100 p-6">
                    <p class="text-xs uppercase tracking-widest text-slate-400">Percakapan Aktif</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-900">Inbox</h2>
                    <p class="text-sm text-slate-500">Atur penawaran, follow-up, dan laporan langsung.</p>
                </div>
                @php
                    $sampleContacts = [
                        ['name' => 'Dhea Ramadhani', 'role' => 'Fashion Enthusiast', 'status' => 'Online', 'badge' => 'Baru', 'thread' => Str::slug('Dhea Ramadhani'), 'unread' => 2],
                        ['name' => 'Gilbert S.', 'role' => 'Tech Hunter', 'status' => 'Ketik...', 'badge' => 'Prioritas', 'thread' => Str::slug('Gilbert S.'), 'unread' => 0],
                        ['name' => 'Rizky', 'role' => 'Vintage Collector', 'status' => 'Terakhir 5m', 'badge' => 'Penawaran', 'thread' => Str::slug('Rizky'), 'unread' => 5],
                    ];
                @endphp
                <div class="divide-y divide-slate-100 flex-1 overflow-y-auto contact-list">
                    @foreach ($sampleContacts as $contact)
                        <button type="button"
                            data-thread="{{ $contact['thread'] }}"
                            class="contact-card flex w-full items-center gap-3 px-6 py-4 text-left hover:bg-emerald-50/60 transition">
                            <div class="relative">
                                <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-200 to-teal-200 flex items-center justify-center font-semibold text-emerald-900">
                                    {{ strtoupper(mb_substr($contact['name'], 0, 1)) }}
                                </div>
                                @if ($contact['unread'])
                                    <span class="absolute -right-1 -top-1 h-5 min-w-[20px] rounded-full bg-rose-500 px-1 text-center text-[11px] font-semibold text-white">
                                        {{ $contact['unread'] }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-slate-900">{{ $contact['name'] }}</p>
                                <p class="text-xs text-slate-500">{{ $contact['role'] }}</p>
                                <p class="text-xs text-emerald-500">{{ $contact['status'] }}</p>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold text-emerald-700">
                                {{ $contact['badge'] }}
                            </span>
                        </button>
                    @endforeach
                </div>
                <div class="p-6 space-y-4">
                    <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 p-4 text-white">
                        <h3 class="text-lg font-semibold">Filter Chat</h3>
                        <p class="text-sm text-emerald-50">Tampilkan hanya penawaran aktif dan laporan terbaru.</p>
                        <div class="mt-4 flex flex-wrap gap-2 text-xs">
                            <span class="rounded-full bg-white/20 px-3 py-1">Penawaran</span>
                            <span class="rounded-full bg-white/20 px-3 py-1">Laporan</span>
                            <span class="rounded-full bg-white/20 px-3 py-1">Favorit</span>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-dashed border-emerald-200 px-4 py-3 text-xs text-slate-500">
                        Tip: gunakan tombol “Edit” untuk melakukan koreksi harga atau detail lainnya sebelum dikirim ke calon pembeli.
                    </div>
                </div>
            </aside>

            @php
                $threads = $messages->groupBy(fn ($message) => Str::slug($message->sender_name));
            @endphp

            <section class="rounded-3xl bg-white shadow-xl shadow-emerald-50/70 ring-1 ring-slate-100 flex flex-col">
                <div class="border-b border-slate-100 p-6 flex flex-wrap items-center gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-slate-400">Percakapan</p>
                        <h2 class="text-2xl font-semibold text-slate-900">Pesan Masuk</h2>
                        <p class="text-sm text-slate-500">Total {{ $messages->count() }} pesan tersimpan.</p>
                    </div>
                    <div class="ml-auto flex items-center gap-4">
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live Sync
                        </span>
                        <button class="rounded-full border border-slate-200 px-3 py-2 text-sm text-slate-500 hover:bg-slate-50" type="button">
                            Export .CSV
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto space-y-8 p-6 bg-slate-50">
                    @forelse ($threads as $threadName => $threadMessages)
                        <div class="chat-thread space-y-8 {{ $loop->first ? '' : 'hidden' }}" data-thread="{{ $threadName }}">
                            @foreach ($threadMessages as $message)
                                <div class="flex {{ $message->is_owner ? 'justify-end' : 'justify-start' }}">
                                    <div class="flex max-w-2xl flex-col gap-2 {{ $message->is_owner ? 'items-end text-right' : 'items-start text-left' }}">
                                        <div class="flex items-center gap-3 text-xs uppercase tracking-widest text-slate-400">
                                            <span class="font-semibold text-slate-600">{{ $message->sender_name }}</span>
                                            @if ($message->sender_role)
                                                <span class="rounded-full bg-white/60 px-3 py-1 text-[10px] font-semibold text-emerald-600">
                                                    {{ $message->sender_role }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="relative rounded-3xl px-5 py-4 text-sm leading-relaxed shadow-lg {{ $message->is_owner ? 'bg-gradient-to-br from-emerald-500 to-teal-500 text-white' : 'bg-white text-slate-700' }}">
                                            <p>{{ $message->body }}</p>
                                            <div class="mt-3 flex items-center gap-3 text-[11px] {{ $message->is_owner ? 'text-white/80' : 'text-slate-400' }}">
                                                <span>
                                                    {{ optional($message->sent_at ?? $message->created_at)->translatedFormat('d M Y - H:i') }}
                                                </span>
                                                <div class="flex items-center gap-2 text-xs font-semibold uppercase">
                                                    <a href="{{ route('chat.edit', $message) }}" class="hover:underline">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('chat.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-rose-500 hover:underline">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-10 text-center">
                            <p class="text-lg font-semibold text-slate-700">Belum ada pesan tersimpan.</p>
                            <p class="text-sm text-slate-500">Mulai percakapan pertama dengan mengirim pesan melalui formulir di bawah.</p>
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-slate-100 bg-white p-6">
                    <form action="{{ route('chat.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Nama Pengirim</label>
                                <input type="text" name="sender_name" value="{{ old('sender_name') }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" placeholder="Cth: Fara Sabila" required>
                            </div>
                            <div>
                                <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Peran / Label</label>
                                <input type="text" name="sender_role" value="{{ old('sender_role') }}" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" placeholder="Penjual, Pembeli, dsb">
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Posisikan sebagai kamu?</label>
                                <input type="checkbox" name="is_owner" value="1" {{ old('is_owner') ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            </div>
                        </div>
                        <div class="grid gap-4 md:grid-cols-[1fr_200px]">
                            <textarea name="body" rows="3" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" placeholder="Tulis pesan baru..." required>{{ old('body') }}</textarea>
                            <div class="flex flex-col gap-3">
                                <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Waktu Pesan</label>
                                <input type="datetime-local" name="sent_at" value="{{ old('sent_at') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                                <button type="submit" class="mt-auto inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200 hover:scale-[1.01] transition">
                                    Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        @isset($editMessage)
            <div class="rounded-3xl bg-white shadow-2xl ring-1 ring-slate-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-slate-400">Mode Edit</p>
                        <h2 class="text-xl font-semibold text-slate-900">Perbarui Pesan</h2>
                    </div>
                    <a href="{{ route('chat.index') }}" class="text-sm font-medium text-slate-500 hover:text-emerald-500">Batal</a>
                </div>
                <form action="{{ route('chat.update', $editMessage) }}" method="POST" class="mt-6 grid gap-4 lg:grid-cols-2">
                    @csrf
                    @method('PUT')
                    <div class="space-y-2">
                        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Nama Pengirim</label>
                        <input type="text" name="sender_name" value="{{ old('sender_name', $editMessage->sender_name) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Peran / Label</label>
                        <input type="text" name="sender_role" value="{{ old('sender_role', $editMessage->sender_role) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div class="lg:col-span-2 space-y-2">
                        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Isi Pesan</label>
                        <textarea name="body" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100" required>{{ old('body', $editMessage->body) }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-semibold uppercase tracking-widest text-slate-500">Waktu Pesan</label>
                        <input type="datetime-local" name="sent_at" value="{{ old('sent_at', optional($editMessage->sent_at ?? $editMessage->created_at)->format('Y-m-d\\TH:i')) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_owner" value="1" {{ old('is_owner', $editMessage->is_owner) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm text-slate-600">Pesan dari kamu</span>
                    </div>
                    <div class="lg:col-span-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200 hover:scale-[1.01] transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
                <form action="{{ route('chat.destroy', $editMessage) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')" class="mt-4 inline-flex">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-semibold text-rose-500 hover:text-rose-600">
                        Hapus Pesan
                    </button>
                </form>
            </div>
        @endisset
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const contacts = document.querySelectorAll('.contact-card');
            const threads = document.querySelectorAll('.chat-thread');

            function activateThread(threadName) {
                threads.forEach((thread) => {
                    thread.classList.toggle('hidden', thread.dataset.thread !== threadName);
                });

                contacts.forEach((card) => {
                    const isActive = card.dataset.thread === threadName;
                    card.classList.toggle('bg-emerald-50', isActive);
                    card.classList.toggle('shadow-inner', isActive);
                });
            }

            contacts.forEach((card) => {
                card.addEventListener('click', () => {
                    activateThread(card.dataset.thread);
                });
            });

            if (contacts.length) {
                activateThread(contacts[0].dataset.thread);
            }
        });
    </script>
@endpush

