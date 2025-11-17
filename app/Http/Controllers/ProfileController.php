<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if ($redirect = $this->redirectIfGuest($request)) {
            return $redirect;
        }

        $profile = $this->profileFor($request);

        return view('profile.show', [
            'profile' => $profile,
            'organizationName' => $request->session()->get('organization_name'),
        ]);
    }

    public function edit(Request $request, Profile $profile): View|RedirectResponse
    {
        if ($redirect = $this->redirectIfGuest($request)) {
            return $redirect;
        }

        $this->authorizeProfile($request, $profile);

        return view('profile.edit', [
            'profile' => $profile,
        ]);
    }

    public function update(Request $request, Profile $profile): RedirectResponse
    {
        if ($redirect = $this->redirectIfGuest($request)) {
            return $redirect;
        }

        $this->authorizeProfile($request, $profile);

        $data = $this->validatedData($request);

        $profile->update($data);

        return redirect()
            ->route('profile.index')
            ->with('status', 'Profil berhasil diperbarui.');
    }

    public function destroy(Request $request, Profile $profile): RedirectResponse
    {
        if ($redirect = $this->redirectIfGuest($request)) {
            return $redirect;
        }

        $this->authorizeProfile($request, $profile);

        $profile->delete();

        return redirect()
            ->route('profile.index')
            ->with('status', 'Profil direset. Data default telah diterapkan.');
    }

    protected function redirectIfGuest(Request $request): ?RedirectResponse
    {
        if (! $request->session()->has('organization_id')) {
            return redirect()
                ->route('login')
                ->with('status', 'Silakan login untuk membuka halaman profil.');
        }

        return null;
    }

    protected function profileFor(Request $request): Profile
    {
        $organizationId = (int) $request->session()->get('organization_id');

        return Profile::firstOrCreate(
            ['organization_id' => $organizationId],
            $this->defaultProfileAttributes($request)
        );
    }

    protected function authorizeProfile(Request $request, Profile $profile): void
    {
        $organizationId = (int) $request->session()->get('organization_id');

        abort_unless($profile->organization_id === $organizationId, 403);
    }

    protected function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'headline' => ['nullable', 'string', 'max:160'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'location' => ['nullable', 'string', 'max:100'],
            'availability_status' => ['nullable', 'string', 'max:120'],
            'rating' => ['nullable', 'numeric', 'between:0,5'],
            'completed_deals' => ['nullable', 'integer', 'min:0'],
            'followers_count' => ['nullable', 'integer', 'min:0'],
            'following_count' => ['nullable', 'integer', 'min:0'],
            'response_rate' => ['nullable', 'integer', 'min:0', 'max:100'],
            'response_time' => ['nullable', 'string', 'max:100'],
            'skills_text' => ['nullable', 'string'],
            'categories_text' => ['nullable', 'string'],
            'avatar_url' => ['nullable', 'url'],
            'cover_url' => ['nullable', 'url'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'portfolio_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'tiktok_url' => ['nullable', 'url'],
            'joined_at' => ['nullable', 'date'],
        ]);

        return [
            'full_name' => $validated['full_name'],
            'headline' => $validated['headline'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'location' => $validated['location'] ?? null,
            'availability_status' => $validated['availability_status'] ?? null,
            'rating' => $validated['rating'] ?? 4.9,
            'completed_deals' => $validated['completed_deals'] ?? 0,
            'followers_count' => $validated['followers_count'] ?? 0,
            'following_count' => $validated['following_count'] ?? 0,
            'response_rate' => $validated['response_rate'] ?? 98,
            'response_time' => $validated['response_time'] ?? 'Dalam 1 jam',
            'skills' => $this->explodeList($validated['skills_text'] ?? ''),
            'favorite_categories' => $this->explodeList($validated['categories_text'] ?? ''),
            'avatar_url' => $validated['avatar_url'] ?? null,
            'cover_url' => $validated['cover_url'] ?? null,
            'contact_email' => $validated['contact_email'] ?? null,
            'contact_phone' => $validated['contact_phone'] ?? null,
            'portfolio_url' => $validated['portfolio_url'] ?? null,
            'social_links' => array_filter([
                'instagram' => $validated['instagram_url'] ?? null,
                'tiktok' => $validated['tiktok_url'] ?? null,
            ]),
            'joined_at' => $validated['joined_at'] ?? null,
        ];
    }

    protected function explodeList(?string $value): array
    {
        return collect(explode(',', (string) $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    protected function defaultProfileAttributes(Request $request): array
    {
        $orgName = $request->session()->get('organization_name', 'NextUse Partner');

        return [
            'full_name' => $orgName,
            'headline' => 'Kurator Barang Bekas Premium',
            'bio' => 'Kami membantu komunitas menghidupkan kembali barang bekas berkualitas melalui kurasi yang selektif dan pengalaman transaksi yang hangat. Fokus pada dampak sosial dan keberlanjutan.',
            'location' => 'Jakarta, Indonesia',
            'availability_status' => 'Tersedia untuk kolaborasi koleksi vintage',
            'rating' => 4.9,
            'completed_deals' => 128,
            'followers_count' => 3200,
            'following_count' => 180,
            'response_rate' => 99,
            'response_time' => '± 30 menit',
            'skills' => ['Kurasi Produk', 'Storytelling', 'Live Shopping'],
            'favorite_categories' => ['Elektronik', 'Fashion', 'Dekorasi'],
            'avatar_url' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=300&q=80',
            'cover_url' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
            'contact_email' => 'hello@nextuse.id',
            'contact_phone' => '+62 812-3456-7890',
            'portfolio_url' => 'https://nextuse.id/portfolio',
            'social_links' => [
                'instagram' => 'https://instagram.com/nextuse.id',
                'tiktok' => 'https://tiktok.com/@nextuse.id',
            ],
            'joined_at' => now()->subYears(2),
        ];
    }
}
