<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatMessageController extends Controller
{
    /**
     * Menampilkan daftar percakapan.
     */
    public function index(Request $request): View
    {
        $organizationId = $request->session()->get('organization_id');

        if (!$organizationId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $latestMessageIds = ChatMessage::query()
            ->where(function ($query) use ($organizationId) {
                $query->where('buyer_id', $organizationId)
                    ->orWhere('seller_id', $organizationId);
            })
            ->selectRaw('MAX(id) as id')
            ->groupBy('conversation_id')
            ->pluck('id');

        $conversationQuery = ChatMessage::query();
        if ($latestMessageIds->isEmpty()) {
            $latestMessages = collect();
        } else {
            $latestMessages = $conversationQuery->whereIn('id', $latestMessageIds)->orderByDesc('sent_at')->get();
        }

        $conversations = $latestMessages
            ->sortByDesc('sent_at')
            ->map(function (ChatMessage $message) use ($organizationId) {
                $contactName = $organizationId === $message->seller_id
                    ? $message->buyer_name
                    : $message->seller_name;

                return [
                    'id' => $message->conversation_id,
                    'name' => $contactName ?? 'Pengguna',
                    'avatar' => strtoupper(substr($contactName ?? 'U', 0, 1)),
                    'item' => $message->item_title ?? '-',
                    'last_message' => $message->body,
                    'timestamp' => optional($message->sent_at)->diffForHumans(),
                    'unread' => $message->is_read ? 0 : 1,
                ];
            })
            ->values();

        return view('chat.index', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * Menampilkan detail percakapan dengan pesan-pesan.
     */
    public function show(Request $request, string $conversationId): View
    {
        $organizationId = $request->session()->get('organization_id');

        if (!$organizationId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $messages = ChatMessage::where('conversation_id', $conversationId)
            ->orderBy('sent_at')
            ->get();

        if ($messages->isEmpty()) {
            abort(404);
        }

        $meta = $messages->first();

        if ($organizationId !== $meta->buyer_id && $organizationId !== $meta->seller_id) {
            abort(403);
        }

        // Tandai pesan sebagai sudah dibaca
        ChatMessage::where('conversation_id', $conversationId)
            ->where(function ($query) use ($organizationId) {
                $query->where('seller_id', $organizationId)
                    ->orWhere('buyer_id', $organizationId);
            })
            ->update(['is_read' => true]);

        $contactName = $organizationId === $meta->seller_id
            ? $meta->buyer_name
            : $meta->seller_name;

        $conversation = [
            'id' => $conversationId,
            'name' => $contactName ?? 'Pengguna',
            'avatar' => strtoupper(substr($contactName ?? 'U', 0, 1)),
            'item' => $meta->item_title ?? '-',
        ];

        return view('chat.show', [
            'conversation' => $conversation,
            'messages' => $messages,
            'currentOrganizationId' => $organizationId,
        ]);
    }
}
