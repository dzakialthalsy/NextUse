<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatMessageController extends Controller
{
    public function index(): View
    {
        return view('chat.index', [
            'messages' => $this->messages(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        ChatMessage::create($data);

        return redirect()
            ->route('chat.index')
            ->with('status', 'Pesan baru berhasil dikirim.');
    }

    public function edit(ChatMessage $chatMessage): View
    {
        return view('chat.index', [
            'messages' => $this->messages(),
            'editMessage' => $chatMessage,
        ]);
    }

    public function update(Request $request, ChatMessage $chatMessage): RedirectResponse
    {
        $data = $this->validatedData($request);

        $chatMessage->update($data);

        return redirect()
            ->route('chat.index')
            ->with('status', 'Pesan berhasil diperbarui.');
    }

    public function destroy(ChatMessage $chatMessage): RedirectResponse
    {
        $chatMessage->delete();

        return redirect()
            ->route('chat.index')
            ->with('status', 'Pesan berhasil dihapus.');
    }

    /**
     * Ambil daftar pesan dengan urutan kronologis.
     */
    protected function messages(): Collection
    {
        return ChatMessage::orderByRaw('COALESCE(sent_at, created_at) ASC')
            ->orderBy('id')
            ->get();
    }

    /**
     * Validasi input pesan.
     */
    protected function validatedData(Request $request): array
    {
        $data = $request->validate([
            'sender_name' => ['required', 'string', 'max:100'],
            'sender_role' => ['nullable', 'string', 'max:100'],
            'body' => ['required', 'string', 'max:1000'],
            'is_owner' => ['nullable', 'boolean'],
            'sent_at' => ['nullable', 'date'],
        ]);

        $data['is_owner'] = $request->boolean('is_owner');
        $data['sent_at'] = $data['sent_at'] ?? now();

        return $data;
    }
}
