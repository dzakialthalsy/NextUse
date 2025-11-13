<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class RegistrasiController extends Controller
{
    /**
     * Tampilkan halaman registrasi organisasi.
     */
    public function index()
    {
        return view('registrasi');
    }

    /**
     * Proses pendaftaran organisasi baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'organizationName' => ['required', 'string', 'max:255'],
                'organizationType' => ['required', 'in:yayasan,kampus,sekolah,pemerintah,komunitas,perusahaan-sosial,lainnya'],
                'organizationId' => ['nullable', 'string', 'max:255'],
                'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:organizations,email'],
                'phone' => ['required', 'string', 'max:30'],
                'contactPerson' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
                'confirmPassword' => ['required', 'same:password'],
                'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
                'agreement' => ['accepted'],
            ],
            [],
            [
                'organizationName' => 'nama organisasi',
                'organizationType' => 'jenis organisasi',
                'organizationId' => 'nomor induk organisasi',
                'email' => 'email organisasi',
                'phone' => 'nomor telepon',
                'contactPerson' => 'penanggung jawab',
                'password' => 'password',
                'confirmPassword' => 'konfirmasi password',
                'document' => 'dokumen organisasi',
                'agreement' => 'persetujuan syarat dan ketentuan',
            ]
        );

        $documentPath = null;

        try {
            if ($request->hasFile('document')) {
                $documentPath = $request->file('document')->store('organization-documents', 'public');
            }

            Organization::create([
                'organization_name' => $validated['organizationName'],
                'organization_type' => $validated['organizationType'],
                'organization_id' => $validated['organizationId'] ?? null,
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'contact_person' => $validated['contactPerson'],
                'password' => $validated['password'],
                'document_path' => $documentPath,
                // Untuk MVP, akun langsung aktif dan siap login.
                'is_active' => true,
            ]);
        } catch (Throwable $th) {
            if ($documentPath) {
                Storage::disk('public')->delete($documentPath);
            }

            throw $th;
        }

        return redirect()
            ->route('login')
            ->with('status', 'Pendaftaran berhasil, silakan masuk menggunakan kredensial organisasi Anda.');
    }
}

