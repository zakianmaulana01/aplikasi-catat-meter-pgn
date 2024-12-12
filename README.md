# Aplikasi Catat Meter PGN

## Deskripsi Proyek
Aplikasi ini adalah sebuah sistem untuk mencatat dan mengelola data meteran gas secara digital. Dibangun menggunakan framework Laravel, aplikasi ini dirancang untuk mempermudah pencatatan data meteran dengan fitur-fitur yang ramah pengguna dan peran pengguna yang terorganisasi.

## Fitur Utama
- **Manajemen Pengguna:** Role-based access control (Admin dan Operator).
- **Pencatatan Meteran:** Formulir pencatatan data meteran yang mudah digunakan.
- **Laporan Data:** Menyediakan laporan data meteran secara real-time.
- **Demo Online dan Video:** Untuk melihat aplikasi berfungsi dengan baik.

## Link Demo Online
- [Demo Online](https://catatmeterzakian.bicarasehat.id/)
  - **Role:** admin
    - **User:** admin
    - **Password:** admin
  - **Role:** operator
    - **User:** operator
    - **Password:** operator

## Link Video Demo
- [Video Demo](https://drive.google.com/drive/folders/1D5JlQsEYvKL88iV49rzVyPTd1kC0mLOy?usp=drive_link)

## Link Repository Git/SCM
- [Repository GitHub](https://github.com/zakianmaulana01/aplikasi-catat-meter-pgn.git)

## Cara Instalasi
1. **Clone Repository**
   ```bash
   git clone https://github.com/zakianmaulana01/aplikasi-catat-meter-pgn.git
   cd aplikasi-catat-meter-pgn
   ```

2. **Install Dependencies**
   Pastikan Composer sudah terinstal, lalu jalankan:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Buat file `.env` dari template yang tersedia:
   ```bash
   cp .env.example .env
   ```
   Sesuaikan konfigurasi database di file `.env`.

4. **Generate Key Aplikasi**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi dan Seed Database**
   Jalankan perintah berikut untuk membuat dan mengisi tabel database:
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Server**
   Jalankan aplikasi dengan perintah berikut:
   ```bash
   php artisan serve
   ```
   Akses aplikasi di [http://localhost:8000](http://localhost:8000).

## Teknologi yang Digunakan
- **Framework:** Laravel 7
- **Database:** MySQL
- **Frontend:** Blade Template Engine
- **Tools:** Composer, Git

## Kontak
Jika ada pertanyaan atau saran terkait proyek ini, silakan hubungi saya di:
- **Email:** [zakianmaulana2001@gmail.com](zakianmaulana2001@gmail.com)
- **GitHub:** [zakianmaulana01](https://github.com/zakianmaulana01)

