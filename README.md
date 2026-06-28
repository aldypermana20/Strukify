# Strukify - Smart Expense Tracker & Receipt Scanner

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![FastAPI](https://img.shields.io/badge/FastAPI-009688?style=for-the-badge&logo=fastapi&logoColor=white)
![Platform](https://img.shields.io/badge/Platform-Web-lightgrey?style=for-the-badge)

## 👥 Identitas Pengembang
**Tim Pengembang Strukify**

<div align='center'>
<br><br>

[![1237050003](https://img.shields.io/badge/003-Aldy%20Permana-blue)](https://github.com/aldypermana20) 
[![1237050041](https://img.shields.io/badge/130-Aditya%20Nurul%20Pratama-blue)](https://github.com/) 
[![1237050069](https://img.shields.io/badge/058-Annisa%20Rasha%20Azaliyya-blue)](https://github.com/) 
[![1237050073](https://img.shields.io/badge/117-Andhika%20Pratama%20Kurniawan-blue)](https://github.com/)
[![1237050073](https://img.shields.io/badge/145-Aura%20Ghifarani-blue)](https://github.com/)
[![1237050073](https://img.shields.io/badge/115-Fauzi%20Rizki-blue)](https://github.com/)

<br>

[![Teknik Informatika](https://img.shields.io/badge/Teknik%20Informatika-UIN%20SGD-blue)](http://if.uinsgd.ac.id/)
[![UIN SGD](https://img.shields.io/badge/UIN-Sunan%20Gunung%20Djati%20Bandung-green)](https://uinsgd.ac.id/)

</div>

---

## 📄 Tentang Strukify
**Strukify** adalah aplikasi *Smart Expense Tracker* berbasis web yang dirancang untuk mempermudah pencatatan pengeluaran harian.  
Aplikasi ini membantu pengguna memindai struk belanja secara otomatis menggunakan *Vision Language Model* (Google Gemini API), mendeteksi harga barang, dan mengekstrak data menjadi format terstruktur (JSON) tanpa perlu input manual yang memakan waktu.

---

# 1. Business Understanding
![Phase](https://img.shields.io/badge/Phase-Analysis-green)

### Latar Belakang Masalah
Dalam mengelola keuangan pribadi maupun bisnis kecil, mencatat setiap pengeluaran dari struk belanja secara manual sangatlah merepotkan. Pengguna seringkali merasa malas atau lupa mencatat pengeluaran kecil, yang menyebabkan **kebocoran anggaran**, **hilangnya data pengeluaran historis**, dan **kesulitan dalam melacak kategori pengeluaran terbesar**.

### Identifikasi Masalah
Proyek ini dikembangkan untuk menjawab permasalahan berikut:
1.  Lamanya waktu yang dibutuhkan untuk menginput item struk belanja satu per satu secara manual.
2.  Tidak adanya rekapitulasi data pengeluaran bulanan yang informatif secara instan.
3.  Susahnya mendeteksi pola belanja dan mengatur keuangan dengan efektif.

### Tujuan Teknis & Kriteria Sukses
* Mengembangkan sistem **Smart Receipt Scan** menggunakan Google Gemini API untuk mengekstrak teks dari foto struk dengan akurasi tinggi.
* Mengimplementasikan fitur **Asynchronous Processing** dengan Laravel Queue agar web tetap responsif saat AI bekerja.
* Mengimplementasikan fitur **Manual Edit & Review** untuk fleksibilitas pengguna dalam memperbaiki data.
* Menyediakan **Dashboard & Analytics** dengan desain *Light Theme* modern untuk visualisasi pengeluaran bulanan.

---

# 2. Modelling (Features & Tech)
![Tech](https://img.shields.io/badge/Tech-Laravel%20x%20FastAPI-yellow)

Solusi ini dibangun menggunakan arsitektur *Monolithic* untuk Frontend & Core Backend, serta *Microservice* untuk pemrosesan AI.

### Fitur Unggulan (The Solution)
1.  **Smart Receipt Scan:** Integrasi FastAPI & Google Gemini API (gemini-2.5-flash) untuk membaca dan mendeteksi item serta total harga dari struk.
2.  **Asynchronous Background Jobs:** Pemrosesan gambar di belakang layar (Queue) agar pengguna tidak perlu menunggu loading lama.
3.  **Review & Edit:** Antarmuka reaktif (Blade & Tailwind) untuk memeriksa hasil scan AI sebelum disimpan permanen.
4.  **Dashboard Analytics:** Visualisasi data pengeluaran (ApexCharts) dan rekapitulasi laporan historis hingga ekspor PDF.

### Teknologi yang Digunakan
* **Frontend & Core Backend:** Laravel 11, Tailwind CSS, Alpine.js.
* **Database:** MySQL.
* **Queue System:** Redis / Database driver.
* **AI Microservice:** Python, FastAPI, Google Generative AI (Gemini).

---

# 3. Data Understanding & Preparation
![Database](https://img.shields.io/badge/Database-MySQL-orange)

### Karakteristik Data
Data disimpan menggunakan struktur relasional pada MySQL dengan tabel utama:
* **Users:** Data autentikasi pengguna.
* **Receipts:** Data transaksi struk utama (`user_id`, `merchant_name`, `total_amount`, `date`, `status`).
* **Receipt Items:** Detail barang dari setiap struk (`receipt_id`, `name`, `price`).
* **Categories:** Master data kategori pengeluaran standar.

### Data Preparation (Logic)
Untuk memastikan data siap digunakan user, kami menerapkan:
* **Background Processing:** Upload gambar langsung dikirim ke *Queue* dan status struk menjadi `processing`.
* **Prompt Engineering:** Memberikan instruksi spesifik ke Gemini API untuk mengembalikan data dalam bentuk JSON mentah tanpa markdown.
* **Data Extraction:** Mengekstrak *store_name*, *receipt_date*, *items*, dan *total* dari JSON dan menyimpannya ke MySQL.

---

## 4. Cara Menjalankan Project (Local Development)

### 1. Menjalankan AI Microservice (FastAPI)

```bash
# Masuk ke direktori AI Service
cd ai-service

# Buat virtual environment
python -m venv venv

# Aktivasi virtual environment (Windows)
.\venv\Scripts\activate

# Instal dependensi Python (FastAPI, google-generativeai, dll)
pip install -r requirements.txt

# Jalankan server FastAPI
python main.py
```

### 2. Menjalankan Laravel (Web App)

Buka terminal baru untuk menjalankan perintah-perintah berikut:

```bash
# Instal dependensi PHP
composer install

# Copy file .env dan generate key
cp .env.example .env
php artisan key:generate

# Konfigurasi Database di .env (pastikan menggunakan kredensial MySQL yang benar)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=strukify
DB_USERNAME=root
DB_PASSWORD=

# WAJIB: Masukkan API Key Gemini di .env
GEMINI_API_KEY=your_gemini_api_key_here

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Buat storage link untuk upload gambar
php artisan storage:link

# Instal dependensi frontend dan jalankan Vite
npm install
npm run dev

# Di terminal baru, jalankan server Laravel
php artisan serve

# Di terminal baru, jalankan Queue Worker untuk pemrosesan AI di background
php artisan queue:work
```

---
# 5. Metodologi Pengembangan (SCRUM)
![Methodology](https://img.shields.io/badge/Method-Agile%20SCRUM-blue)

Proyek ini dikembangkan dengan pendekatan *Agile Development* menggunakan framework **SCRUM**. Pendekatan ini memungkinkan kami untuk mengembangkan fitur secara iteratif, fleksibel terhadap perubahan, dan berfokus pada pengiriman produk yang fungsional di setiap fasenya.

### Peran Tim (Scrum Roles)
- **Product Owner:** Menentukan kebutuhan sistem dan prioritas backlog (Aldy).
- **Scrum Master:** Memfasilitasi proses SCRUM dan integrasi AI (Aldy).
- **Development Team:** Mengembangkan aplikasi Frontend, Backend, UI/UX, dan QA (Andhika, Aura, Annisa, Aditya, Fauzi).

### Alur Pengembangan (Sprints)
Pengembangan dibagi menjadi 4 siklus *Sprint* (durasi 2 minggu), di mana setiap Sprint menghasilkan *Increment*:

* **Sprint 1: Core Foundation & Auth** 
  - Setup arsitektur aplikasi (Laravel).
  - Implementasi autentikasi pengguna (Login/Register).
  - Manajemen kategori dan kerangka awal.
* **Sprint 2: Input Manual & Dashboard**
  - Pengembangan fitur CRUD struk secara manual.
  - Pembuatan visualisasi data pengeluaran dengan ApexCharts.
  - Implementasi *Light Theme* modern.
* **Sprint 3: AI Microservice & Gemini Integration**
  - Setup FastAPI dan integrasi Google Gemini API.
  - Pembuatan *Prompt Engineering* untuk format output JSON yang ketat.
  - Komunikasi antara Laravel dan FastAPI.
* **Sprint 4: Async Processing & Finalization**
  - Implementasi *Laravel Queue* untuk eksekusi AI di background (Asynchronous).
  - Ekspor laporan historis ke format PDF.
  - *Bug fixing*, optimasi performa UI, dan penyusunan dokumentasi/laporan akhir.

---

# 6. Bukti Testing (Testing Evidence)
![Testing](https://img.shields.io/badge/Testing-Evidence-purple)

Bagian ini berisi dokumentasi hasil pengujian sistem beserta bukti *screenshot*-nya.
https://drive.google.com/drive/folders/18lIaVW_vtehoiB6pK7e_Y_phWzgRcMjl?usp=sharing
---
<div align='center'>
<small>Dibuat Oleh Team Strukify | UIN Sunan Gunung Djati Bandung</small>
</div>
