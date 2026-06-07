# Strukify - Smart Expense Tracker & Receipt Scanner

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![FastAPI](https://img.shields.io/badge/FastAPI-009688?style=for-the-badge&logo=fastapi&logoColor=white)
![Platform](https://img.shields.io/badge/Platform-Web-lightgrey?style=for-the-badge)

## 👥 Identitas Pengembang
**Tim Pengembang Strukify**

<div align='center'>
<img src="public/images/aldy.jpg" width="120" height="120" style="border-radius:50%; border: 4px solid #00bfa5; object-fit: cover; margin: 0 10px;"/>
<img src="public/assets/images/Andy.png" width="120" height="120" style="border-radius:50%; border: 4px solid #00bfa5; object-fit: cover; margin: 0 10px;"/>
<img src="public/assets/images/Dapoy.png" width="120" height="120" style="border-radius:50%; border: 4px solid #00bfa5; object-fit: cover; margin: 0 10px;"/>
<img src="public/assets/images/Dimas.png" width="120" height="120" style="border-radius:50%; border: 4px solid #00bfa5; object-fit: cover; margin: 0 10px;"/>

<br><br>

[![1237050003](https://img.shields.io/badge/003-Aldy%20Permana-blue)](https://github.com/aldypermana20) 
[![1237050041](https://img.shields.io/badge/041-Andi%20Muchamad%20Mugni%20P-blue)](https://github.com/Andimugni27) 
[![1237050069](https://img.shields.io/badge/069-Dhaffa%20Zikrullah%20Ramadhan-blue)](https://github.com/dazidhan) 
[![1237050073](https://img.shields.io/badge/073-Dimas%20Rizqia%20Hidayat-blue)](https://github.com/dimaswae)

<br>

[![Teknik Informatika](https://img.shields.io/badge/Teknik%20Informatika-UIN%20SGD-blue)](http://if.uinsgd.ac.id/)
[![UIN SGD](https://img.shields.io/badge/UIN-Sunan%20Gunung%20Djati%20Bandung-green)](https://uinsgd.ac.id/)

</div>

---

## 📄 Tentang Strukify
**Strukify** adalah aplikasi *Smart Expense Tracker* berbasis web yang dirancang untuk mempermudah pencatatan pengeluaran harian.  
Aplikasi ini membantu pengguna memindai struk belanja secara otomatis menggunakan *Artificial Intelligence* (OCR & NLP), mendeteksi harga barang, dan mengkategorikan pengeluaran tanpa perlu input manual yang memakan waktu.

---

# 1. Business Understanding
![Phase](https://img.shields.io/badge/Phase-Analysis-green)

### Latar Belakang Masalah
Dalam mengelola keuangan pribadi maupun bisnis kecil, mencatat setiap pengeluaran dari struk belanja secara manual sangatlah merepotkan. Pengguna seringkali merasa malas atau lupa mencatat pengeluaran kecil, yang menyebabkan **kebocoran anggaran**, **hilangnya data pengeluaran historis**, dan **kesulitan dalam melacak kategori pengeluaran terbesar**.

### Identifikasi Masalah
Proyek ini dikembangkan untuk menjawab permasalahan berikut:
1.  Lamanya waktu yang dibutuhkan untuk menginput item struk belanja satu per satu secara manual.
2.  Kesulitan dalam mengkategorikan pengeluaran belanja (makanan, elektronik, kebutuhan rumah).
3.  Tidak adanya rekapitulasi data pengeluaran bulanan yang informatif.
4.  Susahnya mendeteksi pola belanja dan mengatur keuangan dengan efektif.

### Tujuan Teknis & Kriteria Sukses
* Mengembangkan sistem **Smart Receipt Scan** menggunakan AI untuk mengekstrak teks dari foto struk.
* Membangun sistem **Auto Categorization** untuk mengelompokkan item belanja secara otomatis.
* Mengimplementasikan fitur **Manual Edit & Review** untuk fleksibilitas pengguna.
* Menyediakan **Dashboard & Analytics** untuk visualisasi pengeluaran bulanan.

---

# 2. Modelling (Features & Tech)
![Tech](https://img.shields.io/badge/Tech-Laravel%20x%20FastAPI-yellow)

Solusi ini dibangun menggunakan arsitektur *Monolithic* untuk Frontend & Core Backend, serta *Microservice* untuk pemrosesan AI.

### Fitur Unggulan (The Solution)
1.  **Smart Receipt Scan:** Integrasi FastAPI & EasyOCR untuk membaca dan mendeteksi item dan total harga dari struk.
2.  **Auto Categorization:** Sistem NLP sederhana untuk mengelompokkan pengeluaran ke dalam kategori yang sesuai.
3.  **Review & Edit:** Antarmuka reaktif dengan Alpine.js untuk memeriksa hasil scan AI sebelum disimpan permanen.
4.  **Dashboard Analytics:** Visualisasi data pengeluaran (Chart.js) dan rekapitulasi laporan bulanan hingga ekspor PDF.

### Teknologi yang Digunakan
* **Frontend & Core Backend:** Laravel 13, Tailwind CSS v4, Alpine.js, Vite.
* **Database:** MySQL.
* **AI Microservice:** Python, FastAPI, EasyOCR & PyTorch, OpenCV, NumPy.

---

# 3. Data Understanding & Preparation
![Database](https://img.shields.io/badge/Database-MySQL-orange)

### Karakteristik Data
Data disimpan menggunakan struktur relasional pada MySQL dengan tabel utama:
* **Users:** Data autentikasi pengguna.
* **Receipts:** Data transaksi struk utama (`user_id`, `merchant_name`, `total_amount`, `date`).
* **Receipt Items:** Detail barang dari setiap struk (`receipt_id`, `name`, `price`, `category_id`).
* **Categories:** Master data kategori pengeluaran (Makanan, Transportasi, dsb).

### Data Preparation (Logic)
Untuk memastikan data siap digunakan user, kami menerapkan:
* **Image Processing:** Pre-processing gambar (OpenCV/NumPy) sebelum diumpankan ke model OCR (EasyOCR) untuk meningkatkan akurasi pembacaan.
* **Data Extraction & Regex:** Ekstraksi pola harga dan nama item dari raw text hasil OCR.
* **Reactive UI:** Menggunakan Alpine.js untuk memungkinkan edit *on-the-fly* pada hasil scan tanpa reload halaman.

---

## 4. Cara Menjalankan Project (Local Development)

### 1. Menjalankan Laravel (Web App)

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

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Buat storage link untuk upload gambar
php artisan storage:link

# Instal dependensi frontend dan jalankan Vite
npm install
npm run dev

# Di terminal baru, jalankan server Laravel
php artisan serve
```

### 2. Menjalankan AI Microservice (FastAPI)

```bash
# Masuk ke direktori AI Service
cd ai-service

# Buat virtual environment
python -m venv venv

# Aktivasi virtual environment (Windows)
.\venv\Scripts\activate

# Instal dependensi Python (EasyOCR, PyTorch, FastAPI, dll)
pip install -r requirements.txt

# Jalankan server FastAPI
python main.py
```

---

# 5. Metodologi Pengembangan (SCRUM)
![Methodology](https://img.shields.io/badge/Method-Agile%20SCRUM-blue)

Proyek ini dikembangkan dengan pendekatan *Agile Development* menggunakan framework **SCRUM**. Pendekatan ini memungkinkan kami untuk mengembangkan fitur secara iteratif, fleksibel terhadap perubahan, dan berfokus pada pengiriman produk yang fungsional di setiap fasenya.

### Peran Tim (Scrum Roles)
- **Product Owner:** Menentukan kebutuhan sistem dan prioritas backlog.
- **Scrum Master:** Memfasilitasi proses SCRUM dan menghilangkan hambatan.
- **Development Team:** Mengembangkan aplikasi (Frontend, Backend, AI).

### Alur Pengembangan (Sprints)
Pengembangan dibagi menjadi beberapa siklus *Sprint* (durasi 1-2 minggu), di mana setiap Sprint menghasilkan *Increment* atau fitur yang siap digunakan:

* **Sprint 1: Core Foundation & Auth** 
  - Setup arsitektur aplikasi (Laravel & FastAPI).
  - Implementasi autentikasi pengguna (Login/Register).
  - Pembuatan UI/UX dasar dan Dashboard awal.
* **Sprint 2: AI Microservice & OCR Integration**
  - Pengembangan model EasyOCR di FastAPI.
  - Integrasi komunikasi API antara Laravel dan FastAPI.
  - Fitur upload gambar struk dan ekstraksi teks kasar (*Raw Text*).
* **Sprint 3: Auto Categorization & Smart Checkout**
  - Pemrosesan regex untuk menangkap nama item, harga, dan total.
  - Sistem klasifikasi kategori.
  - Antarmuka reaktif menggunakan Alpine.js untuk verifikasi hasil scan.
* **Sprint 4: Reporting & Finalization**
  - Pembuatan visualisasi data pengeluaran dengan Chart.js.
  - Ekspor laporan bulanan ke format PDF.
  - *Bug fixing*, optimasi performa, dan penyusunan dokumentasi/laporan akhir.

---

<div align='center'>
<small>Made with ❤️ by Team Strukify | UIN Sunan Gunung Djati Bandung</small>
</div>
