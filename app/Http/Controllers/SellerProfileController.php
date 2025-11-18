<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerProfileController extends Controller
{
    /**
     * Tampilkan profil publik pengunggah barang.
     */
    public function __invoke(Request $request, Organization $organization): View
    {
        $profile = Profile::firstOrCreate(
            ['organization_id' => $organization->id],
            [
                'full_name' => $organization->organization_name,
                'location' => 'Jakarta, Indonesia',
            ]
        );

        return view('profile.seller', [
            'profile' => $profile,
            'organization' => $organization,
        ]);
    }
}


