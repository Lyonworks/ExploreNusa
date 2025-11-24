# ExploreNusa

<p align="center">
  <img style="margin-right: 8px;" src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Badge">
  <img style="margin-right: 8px;" src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Badge">
  <img style="margin-right: 8px;" src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL Badge">
  <img style="margin-right: 8px;" src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript Badge">
</p>

**ExploreNusa** adalah aplikasi web berbasis PHP yang didesain untuk memperkenalkan keindahan dan keberagaman destinasi wisata di seluruh Indonesia. Meskipun deskripsi awalnya singkat, proyek ini memiliki potensi besar untuk menjadi platform yang informatif dan menarik bagi para wisatawan lokal maupun mancanegara yang ingin menjelajahi pesona Indonesia.

## Fitur Utama ✨

*   **Destinasi Wisata 🏞️:** Menampilkan informasi detail mengenai berbagai destinasi wisata di Indonesia, lengkap dengan gambar, deskripsi, dan lokasi.
*   **Ulasan dan Rating ⭐:** Memungkinkan pengguna untuk memberikan ulasan dan rating pada destinasi wisata yang telah mereka kunjungi, membantu pengguna lain dalam membuat keputusan.
*   **API Terintegrasi 🌐:** Menyediakan API untuk akses data destinasi dan ulasan, memungkinkan integrasi dengan aplikasi lain.
*   **Manajemen Admin ⚙️:** Panel admin yang mudah digunakan untuk mengelola data destinasi, fasilitas, dan pengguna.

## Tech Stack 🛠️

*   Bahasa Pemrograman: PHP
*   Framework: Laravel (Kemungkinan berdasarkan struktur direktori dan keberadaan controller)
*   Database: MySQL (Kemungkinan berdasarkan pola penggunaan umum pada aplikasi PHP)
*   Frontend: JavaScript, HTML, CSS (Kemungkinan digunakan untuk interaksi dan tampilan antarmuka)

## Instalasi & Menjalankan 🚀

1.  Clone repositori:
    ```bash
    git clone https://github.com/Lyonworks/ExploreNusa
    ```

2.  Masuk ke direktori:
    ```bash
    cd ExploreNusa
    ```

3.  Install dependensi:
    ```bash
    composer install
    npm install # Atau yarn install jika menggunakan Yarn
    ```

4.  Konfigurasi environment:
    * Salin `.env.example` menjadi `.env`
    * Konfigurasi detail database dan pengaturan lainnya di file `.env`

5. Generate key aplikasi:
    ```bash
    php artisan key:generate
    ```

6. Migrasi database dan seeder:
   ```bash
   php artisan migrate --seed
   ```

7. Jalankan proyek:
    ```bash
    php artisan serve
    npm run watch # Atau yarn run watch untuk development
    ```

## Cara Berkontribusi 🤝

1.  Fork repositori ini.
2.  Buat branch untuk fitur Anda (`git checkout -b fitur/fitur-baru`).
3.  Lakukan commit pada perubahan Anda (`git commit -m 'Menambahkan fitur baru'`).
4.  Push ke branch Anda (`git push origin fitur/fitur-baru`).
5.  Buat Pull Request.

