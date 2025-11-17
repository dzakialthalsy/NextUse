<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\RedirectResponse;

class ChatMessageDeleteController extends Controller
{
    /**
     * Menghapus pesan chat.
     */
    public function destroy(ChatMessage $chatMessage): RedirectResponse
    {
        $chatMessage->delete();

        return redirect()
            ->route('chat.index')
            ->with('status', 'Pesan berhasil dihapus.');
    }
}

