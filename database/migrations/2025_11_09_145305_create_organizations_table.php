<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('organization_name');
            $table->enum('organization_type', [
                'yayasan',
                'kampus',
                'sekolah',
                'pemerintah',
                'komunitas',
                'perusahaan-sosial',
                'lainnya'
            ]);
            $table->string('organization_id')->nullable()->comment('Nomor Induk Organisasi atau NIB');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('contact_person')->comment('Nama Penanggung Jawab/Contact Person');
            $table->string('password');
            $table->string('document_path')->nullable()->comment('Path ke file Surat Penugasan/Surat Kuasa');
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
