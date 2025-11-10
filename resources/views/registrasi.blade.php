<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Organisasi - NextUse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @layer utilities {
            .animate-spin {
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-teal-50 via-green-50 to-emerald-50">
    <!-- Main Content -->
    <div class="max-w-[1200px] mx-auto px-6 py-12">
        <div class="grid lg:grid-cols-[560px_1fr] gap-12">
            <!-- Form Section -->
            <div>
                <!-- Title -->
                <div class="mb-8">
                    <h1 class="text-neutral-950 text-center mb-3">Registrasi Organisasi/Instansi</h1>
                    <p class="text-[#717182] text-center">
                        Daftarkan organisasi atau institusi Anda untuk berbagi atau menukar barang secara gratis di platform NextUse.
                    </p>
                </div>

                <!-- Form -->
                <form id="registrationForm" class="space-y-6" onsubmit="handleSubmit(event)">
                    <!-- Nama Organisasi -->
                    <div class="space-y-2">
                        <label for="organizationName" class="block text-sm text-neutral-950">
                            Nama Organisasi/Instansi
                            <span class="text-[#d4183d] ml-1">*</span>
                        </label>
                        <input
                            id="organizationName"
                            type="text"
                            name="organizationName"
                            placeholder="Contoh: Yayasan Peduli Sesama"
                            class="w-full h-9 px-3 py-1 bg-[#f3f3f5] rounded-[10px] text-sm placeholder:text-[#717182] border border-neutral-200 shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-[#009689] focus:border-transparent"
                        />
                        <p id="error-organizationName" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <!-- Jenis Organisasi -->
                    <div class="space-y-2">
                        <label for="organizationType" class="block text-sm text-neutral-950">
                            Jenis Organisasi
                            <span class="text-[#d4183d] ml-1">*</span>
                        </label>
                        <select
                            id="organizationType"
                            name="organizationType"
                            class="w-full h-9 px-3 py-1 bg-[#f3f3f5] rounded-[10px] text-sm border border-neutral-200 shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-[#009689] focus:border-transparent text-[#717182]"
                        >
                            <option value="">Pilih jenis organisasi</option>
                            <option value="yayasan">Yayasan</option>
                            <option value="kampus">Kampus</option>
                            <option value="sekolah">Sekolah</option>
                            <option value="pemerintah">Pemerintah</option>
                            <option value="komunitas">Komunitas</option>
                            <option value="perusahaan-sosial">Perusahaan Sosial</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <p id="error-organizationType" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <!-- Nomor Induk Organisasi -->
                    <div class="space-y-2">
                        <label for="organizationId" class="block text-sm text-neutral-950">
                            Nomor Induk Organisasi atau NIB
                            <span class="text-[#717182] text-xs ml-2">(Opsional)</span>
                        </label>
                        <input
                            id="organizationId"
                            type="text"
                            name="organizationId"
                            placeholder="Contoh: 1234567890123456"
                            class="w-full h-9 px-3 py-1 bg-[#f3f3f5] rounded-[10px] text-sm placeholder:text-[#717182] border border-neutral-200 shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-[#009689] focus:border-transparent"
                        />
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm text-neutral-950">
                            Email Resmi Organisasi
                            <span class="text-[#d4183d] ml-1">*</span>
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="contoh@organisasi.com"
                            class="w-full h-9 px-3 py-1 bg-[#f3f3f5] rounded-[10px] text-sm placeholder:text-[#717182] border border-neutral-200 shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-[#009689] focus:border-transparent"
                        />
                        <p id="error-email" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                        <p id="hint-email" class="text-sm text-[#717182]">Pastikan email unik dan valid</p>
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm text-neutral-950">
                            Nomor Telepon/Kontak PIC
                            <span class="text-[#d4183d] ml-1">*</span>
                        </label>
                        <input
                            id="phone"
                            type="tel"
                            name="phone"
                            placeholder="08xx-xxxx-xxxx"
                            class="w-full h-9 px-3 py-1 bg-[#f3f3f5] rounded-[10px] text-sm placeholder:text-[#717182] border border-neutral-200 shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-[#009689] focus:border-transparent"
                        />
                        <p id="error-phone" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <!-- Nama Penanggung Jawab -->
                    <div class="space-y-2">
                        <label for="contactPerson" class="block text-sm text-neutral-950">
                            Nama Penanggung Jawab/Contact Person
                            <span class="text-[#d4183d] ml-1">*</span>
                        </label>
                        <input
                            id="contactPerson"
                            type="text"
                            name="contactPerson"
                            placeholder="Contoh: Budi Santoso"
                            class="w-full h-9 px-3 py-1 bg-[#f3f3f5] rounded-[10px] text-sm placeholder:text-[#717182] border border-neutral-200 shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-[#009689] focus:border-transparent"
                        />
                        <p id="error-contactPerson" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm text-neutral-950">
                            Password
                            <span class="text-[#d4183d] ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Buat password yang kuat"
                                class="w-full h-9 px-3 pr-10 py-1 bg-[#f3f3f5] rounded-[10px] text-sm placeholder:text-[#717182] border border-neutral-200 shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-[#009689] focus:border-transparent"
                            />
                            <button
                                type="button"
                                onclick="togglePassword('password')"
                                class="absolute right-2 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center"
                            >
                                <svg id="eye-password" class="w-5 h-5" fill="none" viewBox="0 0 20 20" stroke="#717182">
                                    <g>
                                        <path
                                            d="M0.885421 6.95615C0.815971 6.76906 0.815971 6.56325 0.885421 6.37615C1.56184 4.73603 2.71002 3.33369 4.1844 2.3469C5.65878 1.36012 7.39296 0.833333 9.16709 0.833333C10.9412 0.833333 12.6754 1.36012 14.1498 2.3469C15.6242 3.33369 16.7723 4.73603 17.4488 6.37615C17.5182 6.56325 17.5182 6.76906 17.4488 6.95615C16.7723 8.59627 15.6242 9.99862 14.1498 10.9854C12.6754 11.9722 10.9412 12.499 9.16709 12.499C7.39296 12.499 5.65878 11.9722 4.1844 10.9854C2.71002 9.99862 1.56184 8.59627 0.885421 6.95615Z"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.66667"
                                        />
                                        <path
                                            id="eye-slash-password"
                                            d="M3.33333 5.83333C4.71405 5.83333 5.83333 4.71405 5.83333 3.33333C5.83333 1.95262 4.71405 0.833333 3.33333 0.833333C1.95262 0.833333 0.833333 1.95262 0.833333 3.33333C0.833333 4.71405 1.95262 5.83333 3.33333 5.83333Z"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.66667"
                                        />
                                    </g>
                                </svg>
                            </button>
                        </div>
                        <div id="password-strength" class="hidden space-y-1">
                            <div class="flex items-center gap-2">
                                <div class="h-1.5 flex-1 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="password-strength-bar" class="h-full transition-all bg-[#d4183d]" style="width: 0%"></div>
                                </div>
                                <span id="password-strength-label" class="text-xs text-[#717182]"></span>
                            </div>
                        </div>
                        <p id="error-password" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                        <p id="hint-password" class="text-sm text-[#717182]">Minimal 8 karakter dengan kombinasi huruf, angka, dan simbol</p>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="space-y-2">
                        <label for="confirmPassword" class="block text-sm text-neutral-950">
                            Konfirmasi Password
                            <span class="text-[#d4183d] ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input
                                id="confirmPassword"
                                type="password"
                                name="confirmPassword"
                                placeholder="Ulangi password Anda"
                                class="w-full h-9 px-3 pr-10 py-1 bg-[#f3f3f5] rounded-[10px] text-sm placeholder:text-[#717182] border border-neutral-200 shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] focus:outline-none focus:ring-2 focus:ring-[#009689] focus:border-transparent"
                            />
                            <button
                                type="button"
                                onclick="togglePassword('confirmPassword')"
                                class="absolute right-2 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center"
                            >
                                <svg id="eye-confirmPassword" class="w-5 h-5" fill="none" viewBox="0 0 20 20" stroke="#717182">
                                    <g>
                                        <path
                                            d="M0.885421 6.95615C0.815971 6.76906 0.815971 6.56325 0.885421 6.37615C1.56184 4.73603 2.71002 3.33369 4.1844 2.3469C5.65878 1.36012 7.39296 0.833333 9.16709 0.833333C10.9412 0.833333 12.6754 1.36012 14.1498 2.3469C15.6242 3.33369 16.7723 4.73603 17.4488 6.37615C17.5182 6.56325 17.5182 6.76906 17.4488 6.95615C16.7723 8.59627 15.6242 9.99862 14.1498 10.9854C12.6754 11.9722 10.9412 12.499 9.16709 12.499C7.39296 12.499 5.65878 11.9722 4.1844 10.9854C2.71002 9.99862 1.56184 8.59627 0.885421 6.95615Z"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.66667"
                                        />
                                        <path
                                            id="eye-slash-confirmPassword"
                                            d="M3.33333 5.83333C4.71405 5.83333 5.83333 4.71405 5.83333 3.33333C5.83333 1.95262 4.71405 0.833333 3.33333 0.833333C1.95262 0.833333 0.833333 1.95262 0.833333 3.33333C0.833333 4.71405 1.95262 5.83333 3.33333 5.83333Z"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.66667"
                                        />
                                    </g>
                                </svg>
                            </button>
                        </div>
                        <p id="error-confirmPassword" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <!-- Upload Document -->
                    <div class="space-y-2">
                        <label for="document" class="block text-sm text-neutral-950">
                            Upload Surat Penugasan/Surat Kuasa
                            <span class="text-[#d4183d] ml-1">*</span>
                        </label>
                        <div id="document-upload-area" class="border-2 border-dashed border-[#009689] rounded-[10px] p-6 transition-colors bg-teal-50 hover:border-teal-600">
                            <input
                                id="document"
                                type="file"
                                name="document"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="hidden"
                                onchange="handleFileChange(event)"
                            />
                            <label
                                for="document"
                                class="flex flex-col items-center gap-3 cursor-pointer"
                            >
                                <div class="p-3 bg-white rounded-full shadow-sm border border-[#009689]">
                                    <svg class="h-6 w-6 text-[#009689]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p id="document-file-name" class="text-sm text-neutral-950">
                                        Klik untuk pilih file
                                    </p>
                                    <p class="text-xs text-[#717182] mt-1">
                                        PDF, JPG, atau PNG (Maks. 5MB)
                                    </p>
                                </div>
                            </label>
                        </div>
                        <p id="error-document" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <!-- Agreement Checkbox -->
                    <div class="space-y-2">
                        <div class="flex items-start gap-3">
                            <div class="relative pt-0.5">
                                <input
                                    id="agreement"
                                    type="checkbox"
                                    name="agreement"
                                    class="w-4 h-4 rounded bg-[#f3f3f5] border border-neutral-200 checked:bg-[#009689] checked:border-[#009689] focus:ring-2 focus:ring-[#009689] focus:ring-offset-0 cursor-pointer"
                                />
                            </div>
                            <label
                                for="agreement"
                                class="text-sm text-neutral-950 cursor-pointer leading-5 flex-1"
                            >
                                Saya menyatakan data organisasi valid & setuju dengan{' '}
                                <a href="#" class="text-[#009689] underline hover:text-teal-700">
                                    Syarat & Ketentuan
                                </a>{' '}
                                NextUse
                                <span class="text-[#d4183d] ml-1">*</span>
                            </label>
                        </div>
                        <p id="error-agreement" class="text-sm text-[#d4183d] hidden flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span></span>
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            id="submitBtn"
                            class="w-full h-9 bg-gradient-to-r from-[#00bba7] to-[#009966] text-white text-sm rounded-[10px] shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                        >
                            <span id="submitText">Daftarkan Organisasi</span>
                            <svg id="submitLoader" class="h-4 w-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Secondary Actions -->
                    <div class="space-y-2 pt-4">
                        <p class="text-sm text-[#717182] text-center">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-[#009689] hover:underline">
                                Masuk di sini
                            </a>
                        </p>
                        <p class="text-sm text-center">
                            <a href="#" class="text-[#717182] underline hover:text-neutral-950">
                                Lihat S&K
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Sticky Sidebar -->
            <div class="hidden lg:block">
                <div class="sticky top-8 space-y-6">
                    <!-- Info Card -->
                    <div class="bg-teal-50 border border-teal-200 rounded-lg p-6 shadow-sm">
                        <h3 class="flex items-center gap-2 mb-4 text-neutral-950">
                            <svg class="h-5 w-5 text-[#009689]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Keuntungan Bergabung
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-white rounded-lg shadow-sm border border-teal-200">
                                    <svg class="h-4 w-4 text-[#009689]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <p class="text-sm text-neutral-950 leading-relaxed">
                                    Distribusi barang gratis untuk organisasi yang membutuhkan
                                </p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-white rounded-lg shadow-sm border border-teal-200">
                                    <svg class="h-4 w-4 text-[#009689]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-neutral-950 leading-relaxed">
                                    Jejaring organisasi sosial se-Indonesia
                                </p>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-white rounded-lg shadow-sm border border-teal-200">
                                    <svg class="h-4 w-4 text-[#009689]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-neutral-950 leading-relaxed">
                                    Platform aman dan terverifikasi
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements Card -->
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 shadow-sm">
                        <h3 class="flex items-center gap-2 mb-4 text-neutral-950">
                            <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Dokumen yang Diperlukan
                        </h3>
                        <ul class="space-y-2.5 text-sm text-neutral-950">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Surat penugasan/kuasa resmi
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Email resmi organisasi (aktif)
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Data penanggung jawab
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Nomor kontak yang dapat dihubungi
                            </li>
                        </ul>
                    </div>

                    <!-- Help Card -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 shadow-sm">
                        <p class="text-sm text-neutral-950 mb-3">
                            Butuh bantuan? Hubungi tim NextUse:
                        </p>
                        <div class="space-y-2">
                            <a href="mailto:support@nextuse.id" class="flex items-center gap-2 text-sm text-[#009689] hover:underline">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                support@nextuse.id
                            </a>
                            <a href="tel:+6281234567890" class="flex items-center gap-2 text-sm text-[#009689] hover:underline">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                +62 812-3456-7890
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-[rgba(0,0,0,0.1)] mt-16">
        <div class="max-w-[1200px] mx-auto px-6 py-6">
            <p class="text-sm text-[#717182] text-center">
                © 2025 NextUse. Platform berbagi dan barter barang gratis.
            </p>
        </div>
    </footer>

    <script>
        // Password visibility toggle
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(`eye-${fieldId}`);
            const eyeSlash = document.getElementById(`eye-slash-${fieldId}`);
            
            if (field.type === 'password') {
                field.type = 'text';
                if (eyeSlash) eyeSlash.style.display = 'none';
            } else {
                field.type = 'password';
                if (eyeSlash) eyeSlash.style.display = 'block';
            }
        }

        // Password strength calculator
        function calculatePasswordStrength(pass) {
            if (!pass) return 0;
            let strength = 0;
            if (pass.length >= 8) strength += 25;
            if (pass.length >= 12) strength += 25;
            if (/[a-z]/.test(pass) && /[A-Z]/.test(pass)) strength += 25;
            if (/[0-9]/.test(pass)) strength += 12.5;
            if (/[^a-zA-Z0-9]/.test(pass)) strength += 12.5;
            return Math.min(strength, 100);
        }

        function getPasswordStrengthLabel(strength) {
            if (strength === 0) return '';
            if (strength < 50) return 'Lemah';
            if (strength < 75) return 'Sedang';
            return 'Kuat';
        }

        function getPasswordStrengthColor(strength) {
            if (strength < 50) return '#d4183d';
            if (strength < 75) return '#eab308';
            return '#009689';
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strength = calculatePasswordStrength(password);
            const strengthDiv = document.getElementById('password-strength');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthLabel = document.getElementById('password-strength-label');

            if (password && strength > 0) {
                strengthDiv.classList.remove('hidden');
                strengthBar.style.width = strength + '%';
                strengthBar.style.backgroundColor = getPasswordStrengthColor(strength);
                strengthLabel.textContent = getPasswordStrengthLabel(strength);
            } else {
                strengthDiv.classList.add('hidden');
            }
        });

        // File upload handler
        function handleFileChange(e) {
            const file = e.target.files?.[0];
            const fileNameEl = document.getElementById('document-file-name');
            const uploadArea = document.getElementById('document-upload-area');
            const errorEl = document.getElementById('error-document');

            if (file) {
                const validTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
                const maxSize = 5 * 1024 * 1024; // 5MB

                if (!validTypes.includes(file.type)) {
                    showError('document', 'Format file tidak valid. Gunakan PDF, JPG, atau PNG.');
                    e.target.value = '';
                    fileNameEl.textContent = 'Klik untuk pilih file';
                    uploadArea.classList.remove('border-[#d4183d]', 'bg-red-50');
                    uploadArea.classList.add('border-[#009689]', 'bg-teal-50');
                    return;
                }

                if (file.size > maxSize) {
                    showError('document', 'Ukuran file maksimal 5MB.');
                    e.target.value = '';
                    fileNameEl.textContent = 'Klik untuk pilih file';
                    uploadArea.classList.remove('border-[#d4183d]', 'bg-red-50');
                    uploadArea.classList.add('border-[#009689]', 'bg-teal-50');
                    return;
                }

                fileNameEl.textContent = file.name;
                hideError('document');
                uploadArea.classList.remove('border-[#d4183d]', 'bg-red-50');
                uploadArea.classList.add('border-[#009689]', 'bg-teal-50');
            }
        }

        // Error display functions
        function showError(field, message) {
            const errorEl = document.getElementById(`error-${field}`);
            const inputEl = document.getElementById(field);
            if (errorEl && inputEl) {
                errorEl.classList.remove('hidden');
                errorEl.querySelector('span').textContent = message;
                inputEl.classList.remove('border-neutral-200');
                inputEl.classList.add('border-[#d4183d]');
            }
        }

        function hideError(field) {
            const errorEl = document.getElementById(`error-${field}`);
            const inputEl = document.getElementById(field);
            if (errorEl && inputEl) {
                errorEl.classList.add('hidden');
                inputEl.classList.remove('border-[#d4183d]');
                inputEl.classList.add('border-neutral-200');
            }
        }

        // Form validation
        function validateForm() {
            let isValid = true;
            const form = document.getElementById('registrationForm');
            const formData = new FormData(form);

            // Reset all errors
            ['organizationName', 'organizationType', 'email', 'phone', 'contactPerson', 'password', 'confirmPassword', 'document', 'agreement'].forEach(field => {
                hideError(field);
            });

            // Validate organization name
            const orgName = formData.get('organizationName');
            if (!orgName || orgName.trim() === '') {
                showError('organizationName', 'Nama organisasi wajib diisi');
                isValid = false;
            }

            // Validate organization type
            const orgType = formData.get('organizationType');
            if (!orgType || orgType === '') {
                showError('organizationType', 'Jenis organisasi wajib dipilih');
                isValid = false;
            } else {
                // Update select text color
                document.getElementById('organizationType').classList.remove('text-[#717182]');
                document.getElementById('organizationType').classList.add('text-neutral-950');
            }

            // Validate email
            const email = formData.get('email');
            const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;
            if (!email || email.trim() === '') {
                showError('email', 'Email wajib diisi');
                isValid = false;
            } else if (!emailRegex.test(email)) {
                showError('email', 'Format email tidak valid');
                isValid = false;
            }

            // Validate phone
            const phone = formData.get('phone');
            const phoneRegex = /^[0-9+\-\s()]{10,}$/;
            if (!phone || phone.trim() === '') {
                showError('phone', 'Nomor telepon wajib diisi');
                isValid = false;
            } else if (!phoneRegex.test(phone)) {
                showError('phone', 'Nomor telepon tidak valid');
                isValid = false;
            }

            // Validate contact person
            const contactPerson = formData.get('contactPerson');
            if (!contactPerson || contactPerson.trim() === '') {
                showError('contactPerson', 'Nama penanggung jawab wajib diisi');
                isValid = false;
            }

            // Validate password
            const password = formData.get('password');
            if (!password || password.trim() === '') {
                showError('password', 'Password wajib diisi');
                isValid = false;
            } else if (password.length < 8) {
                showError('password', 'Password minimal 8 karakter');
                isValid = false;
            }

            // Validate confirm password
            const confirmPassword = formData.get('confirmPassword');
            if (!confirmPassword || confirmPassword.trim() === '') {
                showError('confirmPassword', 'Konfirmasi password wajib diisi');
                isValid = false;
            } else if (password && confirmPassword !== password) {
                showError('confirmPassword', 'Password tidak cocok');
                isValid = false;
            }

            // Validate document
            const document = formData.get('document');
            if (!document || document.size === 0) {
                showError('document', 'Dokumen wajib diunggah');
                const uploadArea = document.getElementById('document-upload-area');
                uploadArea.classList.remove('border-[#009689]', 'bg-teal-50');
                uploadArea.classList.add('border-[#d4183d]', 'bg-red-50');
                isValid = false;
            }

            // Validate agreement
            const agreement = formData.get('agreement');
            if (!agreement) {
                showError('agreement', 'Anda harus menyetujui syarat dan ketentuan');
                isValid = false;
            }

            return isValid;
        }

        // Form submit handler
        async function handleSubmit(event) {
            event.preventDefault();

            if (!validateForm()) {
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoader = document.getElementById('submitLoader');
            const form = document.getElementById('registrationForm');
            const formData = new FormData(form);

            // Disable submit button
            submitBtn.disabled = true;
            submitText.textContent = 'Mendaftarkan...';
            submitLoader.classList.remove('hidden');

            // Simulate API call
            await new Promise(resolve => setTimeout(resolve, 2000));

            // Mock validation for unique email
            const email = formData.get('email');
            const mockExistingEmails = ['test@example.com', 'org@sample.com'];
            if (mockExistingEmails.includes(email.toLowerCase())) {
                showError('email', 'Email sudah terdaftar. Gunakan email lain.');
                submitBtn.disabled = false;
                submitText.textContent = 'Daftarkan Organisasi';
                submitLoader.classList.add('hidden');
                return;
            }

            // Success - show alert (you can replace this with a toast library)
            alert('Pendaftaran berhasil, silakan cek email resmi organisasi untuk verifikasi');

            // Reset form
            form.reset();
            document.getElementById('document-file-name').textContent = 'Klik untuk pilih file';
            document.getElementById('password-strength').classList.add('hidden');
            document.getElementById('organizationType').classList.remove('text-neutral-950');
            document.getElementById('organizationType').classList.add('text-[#717182]');
            const uploadArea = document.getElementById('document-upload-area');
            uploadArea.classList.remove('border-[#d4183d]', 'bg-red-50');
            uploadArea.classList.add('border-[#009689]', 'bg-teal-50');

            // Re-enable submit button
            submitBtn.disabled = false;
            submitText.textContent = 'Daftarkan Organisasi';
            submitLoader.classList.add('hidden');
        }

        // Real-time validation on blur
        document.getElementById('organizationName').addEventListener('blur', function() {
            if (!this.value.trim()) {
                showError('organizationName', 'Nama organisasi wajib diisi');
            } else {
                hideError('organizationName');
            }
        });

        document.getElementById('organizationType').addEventListener('change', function() {
            if (!this.value) {
                showError('organizationType', 'Jenis organisasi wajib dipilih');
                this.classList.remove('text-neutral-950');
                this.classList.add('text-[#717182]');
            } else {
                hideError('organizationType');
                this.classList.remove('text-[#717182]');
                this.classList.add('text-neutral-950');
            }
        });

        document.getElementById('email').addEventListener('blur', function() {
            const emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;
            if (!this.value.trim()) {
                showError('email', 'Email wajib diisi');
                document.getElementById('hint-email').classList.add('hidden');
            } else if (!emailRegex.test(this.value)) {
                showError('email', 'Format email tidak valid');
                document.getElementById('hint-email').classList.add('hidden');
            } else {
                hideError('email');
                document.getElementById('hint-email').classList.remove('hidden');
            }
        });

        document.getElementById('phone').addEventListener('blur', function() {
            const phoneRegex = /^[0-9+\-\s()]{10,}$/;
            if (!this.value.trim()) {
                showError('phone', 'Nomor telepon wajib diisi');
            } else if (!phoneRegex.test(this.value)) {
                showError('phone', 'Nomor telepon tidak valid');
            } else {
                hideError('phone');
            }
        });

        document.getElementById('contactPerson').addEventListener('blur', function() {
            if (!this.value.trim()) {
                showError('contactPerson', 'Nama penanggung jawab wajib diisi');
            } else {
                hideError('contactPerson');
            }
        });

        document.getElementById('password').addEventListener('blur', function() {
            if (!this.value.trim()) {
                showError('password', 'Password wajib diisi');
                document.getElementById('hint-password').classList.add('hidden');
            } else if (this.value.length < 8) {
                showError('password', 'Password minimal 8 karakter');
                document.getElementById('hint-password').classList.add('hidden');
            } else {
                hideError('password');
                document.getElementById('hint-password').classList.remove('hidden');
            }
        });

        document.getElementById('confirmPassword').addEventListener('blur', function() {
            const password = document.getElementById('password').value;
            if (!this.value.trim()) {
                showError('confirmPassword', 'Konfirmasi password wajib diisi');
            } else if (this.value !== password) {
                showError('confirmPassword', 'Password tidak cocok');
            } else {
                hideError('confirmPassword');
            }
        });

        document.getElementById('agreement').addEventListener('change', function() {
            if (!this.checked) {
                showError('agreement', 'Anda harus menyetujui syarat dan ketentuan');
            } else {
                hideError('agreement');
            }
        });
    </script>
</body>
</html>

