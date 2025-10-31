# Proyek Laravel dengan Docker (NextUse)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center"> <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a> <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a> </p>

## Tentang Laravel

Laravel adalah *framework* aplikasi web dengan sintaks yang ekspresif dan elegan. Laravel menghilangkan kesulitan dalam pengembangan dengan mempermudah tugas-tugas umum yang digunakan dalam banyak proyek web, seperti: *routing* yang sederhana dan cepat, *dependency injection container* yang kuat, ORM basis data yang ekspresif (*Eloquent*), dan pemrosesan *background job* yang tangguh.

-----

## Prasyarat (Prerequisites)

Untuk menjalankan proyek ini, Anda memerlukan perangkat lunak berikut yang terinstal di sistem Anda:

  * **Git**
  * **Docker** dan **Docker Compose** (termasuk Docker Desktop untuk Windows/Mac)

-----

## Panduan Instalasi dan Menjalankan Proyek

Proyek ini menggunakan **Docker Compose** untuk menyediakan lingkungan pengembangan yang konsisten, termasuk *container* **PHP 8.2** (dengan Apache), **MySQL 8.0**, dan **phpMyAdmin**.

### 1\. Kloning Repositori

Kloning repositori proyek ke mesin lokal Anda:

```bash
git clone https://github.com/dzakialthalsy/NextUse.git
cd dzakialthalsy/nextuse/NextUse-fb508e3c113c11c256251280b1f75af8058ce735
```

### 2\. Konfigurasi Environment (Lingkungan)

Buat salinan file konfigurasi *environment* dari contoh yang disediakan:

```bash
cp .env.example .env
```

Pastikan konfigurasi koneksi basis data di file `.env` sudah sesuai dengan layanan `mysql` di `docker-compose.yml`.

| Variabel `.env` | Nilai yang Diharapkan | Keterangan |
| :--- | :--- | :--- |
| `DB_CONNECTION` | `mysql` | |
| `DB_HOST` | `mysql` | Nama layanan di `docker-compose.yml` |
| `DB_PORT` | `3306` | |
| `DB_DATABASE` | `nextuse` | |
| `DB_USERNAME` | `user` | |
| `DB_PASSWORD` | `password` | |

### 3\. Bangun dan Jalankan Container

Gunakan Docker Compose untuk membangun (*build*) image `app` (berdasarkan `Dockerfile`) dan menjalankan semua layanan.

```bash
docker compose up -d --build
```

  * `app` (Laravel) akan dapat diakses di **http://localhost:8000**.
  * `mysql` akan dapat diakses di port **3306**.
  * `phpmyadmin` akan dapat diakses di **http://localhost:8080**.

### 4\. Instalasi Dependensi Laravel dan Setup Awal

Setelah *container* berjalan, Anda perlu menjalankan skrip instalasi untuk memasang dependensi PHP dan Node.js, menghasilkan kunci aplikasi, dan menjalankan migrasi basis data.

Akses *container* `app` dan jalankan skrip `setup` yang didefinisikan dalam `composer.json` di dalam direktori `src`:

```bash
docker compose exec app bash -c "cd src && composer run setup"
```

Skrip `setup` akan menjalankan perintah berikut secara otomatis:

  * `composer install`: Menginstal dependensi PHP.
  * `@php artisan key:generate`: Membuat kunci aplikasi.
  * `@php artisan migrate --force`: Menjalankan migrasi database.
  * `npm install`: Menginstal dependensi Node.js.
  * `npm run build`: Membangun aset frontend (CSS/JS) dengan Vite.

### 5\. Pengembangan Aktif (Development)

Untuk pengembangan aktif, Anda dapat menjalankan beberapa proses sekaligus (server PHP, queue listener, log tail, dan Vite dev server) menggunakan skrip `dev` di `composer.json`.

```bash
docker compose exec app bash -c "cd src && composer run dev"
```

*Skrip `dev` menggunakan `npx concurrently` untuk menjalankan `php artisan serve`, `php artisan queue:listen`, `php artisan pail --timeout=0`, dan `npm run dev` secara bersamaan.*

-----

## Dokumentasi dan Sumber Belajar

Laravel memiliki [dokumentasi](https://laravel.com/docs) dan perpustakaan tutorial video yang paling ekstensif.

  * **Dokumentasi:** Baca [dokumentasi Laravel](https://laravel.com/docs) untuk panduan mendalam tentang semua fitur.
  * **Laracasts:** Tonton tutorial video di [Laracasts](https://laracasts.com) untuk berbagai topik termasuk Laravel, PHP modern, dan pengujian unit.

-----

## Kontribusi

Terima kasih telah mempertimbangkan untuk berkontribusi pada *framework* Laravel\! Panduan kontribusi dapat ditemukan di [dokumentasi Laravel](https://laravel.com/docs/contributions). Harap tinjau dan patuhi [Kode Etik](https://laravel.com/docs/contributions#code-of-conduct) untuk memastikan komunitas yang ramah bagi semua.

-----

## Lisensi

*Framework* Laravel adalah *open-sourced software* yang dilisensikan di bawah [lisensi MIT](https://opensource.org/licenses/MIT).
