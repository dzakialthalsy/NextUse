@extends('layouts.app')

@section('title', 'Chat - ' . $conversation['user']['name'] . ' - NextUse')

@section('content')
    <div class="max-w-4xl mx-auto flex flex-col h-[calc(100vh-120px)]">
        {{-- Chat Header --}}
        <div class="flex items-center gap-4 border-b border-slate-200 bg-white px-4 py-4">
            <a href="{{ route('chat.index') }}" class="flex-shrink-0 text-slate-600 hover:text-slate-900">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            
            <div class="flex items-center gap-3 flex-1 min-w-0">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-semibold flex-shrink-0">
                    {{ $conversation['user']['avatar'] }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-900 truncate">{{ $conversation['user']['name'] }}</p>
                    <div class="flex items-center gap-1.5">
                        <svg class="h-3 w-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                        </svg>
                        <p class="text-xs text-emerald-600 font-medium truncate">{{ $conversation['user']['item'] }}</p>
                    </div>
                </div>
            </div>

            <button type="button" class="flex-shrink-0 text-slate-600 hover:text-slate-900">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </button>
        </div>

        {{-- Chat Messages --}}
        <div class="flex-1 overflow-y-auto bg-slate-50 px-4 py-6 space-y-4">
            {{-- Date Separator --}}
            <div class="flex items-center justify-center">
                <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-600">Hari ini</span>
            </div>

            {{-- Messages --}}
            @foreach ($conversation['messages'] as $message)
                <div class="flex {{ $message['sender'] === 'user' ? 'justify-start' : 'justify-end' }}">
                    <div class="flex max-w-[75%] flex-col gap-1 {{ $message['sender'] === 'user' ? 'items-start' : 'items-end' }}">
                        <div class="rounded-2xl px-4 py-2.5 text-sm leading-relaxed {{ $message['sender'] === 'user' ? 'bg-white text-slate-700 shadow-sm' : 'bg-gradient-to-br from-emerald-500 to-teal-500 text-white' }}">
                            <p>{{ $message['text'] }}</p>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] text-slate-400">
                            <span>{{ $message['time'] }}</span>
                            @if (isset($message['read']) && $message['read'])
                                <svg class="h-3 w-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Input Bar --}}
        <div class="border-t border-slate-200 bg-white px-4 py-3">
            <div class="flex items-center gap-3">
                <button type="button" class="flex-shrink-0 text-slate-400 hover:text-slate-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
                <button type="button" class="flex-shrink-0 text-slate-400 hover:text-slate-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                </button>
                <input type="text" placeholder="Ketik pesan..." 
                    class="flex-1 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-emerald-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-100">
                <button type="button" class="flex-shrink-0 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 p-2.5 text-white hover:shadow-lg transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endsection

