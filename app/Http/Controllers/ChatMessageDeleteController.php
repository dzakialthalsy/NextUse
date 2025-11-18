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
        $conversationId = $chatMessage->conversation_id;
        $chatMessage->delete();

        return redirect()
            ->route('chat.show', $conversationId)
            ->with('status', 'Pesan berhasil dihapus.');
    }
}

