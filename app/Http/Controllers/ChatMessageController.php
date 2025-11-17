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
        // Dummy data untuk list percakapan
        $conversations = $this->getConversations();
        
        return view('chat.index', [
            'conversations' => $conversations,
        ]);
    }

    public function show(string $userId): View
    {
        // Dummy data untuk detail chat dengan user tertentu
        $conversation = $this->getConversationDetail($userId);
        
        return view('chat.show', [
            'conversation' => $conversation,
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
     * Ambil daftar percakapan dummy.
     */
    protected function getConversations(): array
    {
        return [
            [
                'id' => 'siti-nurhaliza',
                'name' => 'Siti Nurhaliza',
                'avatar' => 'S',
                'item' => 'Kamera Digital Canon EOS 700D',
                'last_message' => 'Terima kasih! Barangnya sudah saya terima 😊',
                'timestamp' => '14.38',
                'unread' => 0,
                'is_you' => false,
            ],
            [
                'id' => 'budi-santoso',
                'name' => 'Budi Santoso',
                'avatar' => 'B',
                'item' => 'Rice Cooker Miyako 1.8L',
                'last_message' => 'Baik, saya bisa ambil besok jam 2 siang',
                'timestamp' => '13.48',
                'unread' => 2,
                'is_you' => false,
            ],
            [
                'id' => 'rina-wijaya',
                'name' => 'Rina Wijaya',
                'avatar' => 'R',
                'item' => 'Meja Belajar Kayu Jati',
                'last_message' => 'Anda: Oke, ditunggu',
                'timestamp' => '12.48',
                'unread' => 0,
                'is_you' => true,
            ],
            [
                'id' => 'dedi-kurniawan',
                'name' => 'Dedi Kurniawan',
                'avatar' => 'D',
                'item' => 'Laptop Dell Inspiron 15',
                'last_message' => 'Lokasi masih sama dengan yang di profil?',
                'timestamp' => 'Kemarin',
                'unread' => 1,
                'is_you' => false,
            ],
        ];
    }

    /**
     * Ambil detail percakapan dummy.
     */
    protected function getConversationDetail(string $userId): array
    {
        $conversations = $this->getConversations();
        $conversation = collect($conversations)->firstWhere('id', $userId);
        
        if (!$conversation) {
            abort(404);
        }

        // Dummy messages untuk percakapan
        $messages = [
            [
                'sender' => 'user',
                'text' => 'Halo, saya tertarik dengan kameranya. Masih tersedia?',
                'time' => '12.48',
            ],
            [
                'sender' => 'contact',
                'text' => 'Halo! Ya masih tersedia. Kondisinya masih sangat bagus, jarang dipakai.',
                'time' => '12.51',
                'read' => true,
            ],
            [
                'sender' => 'user',
                'text' => 'Wah bagus! Bisa diambil kapan ya?',
                'time' => '13.48',
            ],
            [
                'sender' => 'contact',
                'text' => 'Besok atau lusa bisa. Kamu lebih enak kapan?',
                'time' => '13.50',
                'read' => true,
            ],
            [
                'sender' => 'user',
                'text' => 'Besok siang bisa. Jam 2 gimana?',
                'time' => '14.18',
            ],
            [
                'sender' => 'contact',
                'text' => 'Oke deal! Lokasi di Jakarta Selatan ya, alamat lengkap saya kirim via maps.',
                'time' => '14.28',
                'read' => true,
            ],
            [
                'sender' => 'user',
                'text' => 'Terima kasih! Barangnya sudah saya terima 😊',
                'time' => '14.38',
            ],
        ];

        return [
            'user' => $conversation,
            'messages' => $messages,
        ];
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
