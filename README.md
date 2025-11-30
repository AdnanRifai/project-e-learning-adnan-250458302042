# **El Lesson – E-Learning Platform**

El Lesson adalah platform e-learning yang dikembangkan menggunakan **Laravel**, **Livewire**, dan **Android Kotlin**. Sistem ini dirancang untuk menyediakan proses pembelajaran digital yang terstruktur melalui Course, Module, Lesson, komentar bertingkat, serta integrasi API untuk aplikasi mobile.

---

## **1. Fitur Utama**

### **A. Role User**

* Registrasi & login menggunakan autentikasi Laravel.
* Mengikuti course (free atau berbayar).
* Mengakses modul dan lesson berdasarkan urutan.
* Mendapatkan preview gratis untuk lesson tertentu.
* Menyimpan progres pembelajaran (frontend + API Android).
* Sistem komentar dengan nested replies seperti YouTube.
* Melihat statistik pembelajaran pribadi.
* Mengedit profil (tanpa upload gambar).
* Terintegrasi API untuk aplikasi Android (data real-time).

### **B. Role Admin**

* CRUD Course, Module, Lesson menggunakan Livewire.
* Manajemen komentar.
* Manajemen pengguna.
* Statistik global aktivitas pengguna.
* Dashboard admin lengkap (course, quiz, komentar, dsb).

---

## **2. Arsitektur Sistem**

### **Backend**

* **Laravel 10/11**
* **Livewire** untuk admin panel
* **Eloquent ORM** sebagai query layer
* **REST API** untuk Android Kotlin
* **Middleware:** auth, role, serta role.redirect

### **Frontend Web**

* Blade Template
* Bootstrap / komponen admin
* Livewire Component

### **Mobile**

* **Android Kotlin**
* Retrofit untuk API
* Fragment + Adapter untuk menampilkan data
* Fitur statistik, detail siswa, edit profil, dll.

---

## **3. Struktur Konten Pembelajaran**

```
Course
 └── Module
      └── Lesson
```

Setiap lesson memiliki:

* title
* slug
* content
* duration
* free_preview
* position

Slug dibuat otomatis saat proses creating.

---

## **4. Sistem Komentar**

* Model `Komentar` untuk struktur komentar + nested replies.
* User dapat memberikan komentar dan balasan.
* Komentar bertingkat (inspired by YouTube).
* Relasi komentar dengan User, Modul, dan parent comment.

---

## **5. Integrasi API Android**

Endpoint digunakan untuk:

* Menampilkan daftar student.
* Menampilkan statistik pembelajaran.
* Mengambil dan mengupdate profil user.
* Mengambil data course/module/lesson.
* Menyinkronkan progres user di mobile.

Aplikasi Android memanfaatkan:

* Fragment
* RecyclerView + Adapter
* ViewBinding
* Kotlin Coroutines
* Retrofit

---

## **6. Fitur Tambahan**

* Quiz per modul.
* Pengelolaan soal (pertanyaan, pilihan, jawaban).
* Penilaian otomatis berdasarkan kunci jawaban.
* Perhitungan progres belajar (diperluas melalui API).

---

## **7. Instalasi & Setup**

### **Backend (Laravel)**

```
git clone <repository>
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### **Frontend Admin**

Tidak memerlukan build khusus; menggunakan Livewire.

### **Android**

* Buka proyek di Android Studio.
* Sesuaikan base URL API Laravel.
* Jalankan aplikasi melalui emulator atau perangkat fisik.

---

## **8. Teknologi yang Digunakan**

* **Laravel**
* **Livewire**
* **MySQL**
* **Kotlin**
* **Retrofit**
* **Blade**
* **Bootstrap**
* **Eloquent ORM**

---

## **9. Pengembangan Lanjutan**

* Menyatukan model komentar (`Komentar` & `AddKomentar`).
* Membuat tabel progress user-course.
* Implementasi sistem pembayaran.
* Menambah rekomendasi berdasarkan aktivitas belajar.
* Mengoptimalisasi performa saat memuat nested comments.

---

## **10. Lisensi**

Proyek ini bersifat private dan dikembangkan untuk kebutuhan pembelajaran dan pengembangan pribadi.

---

## **11. Kontributor**

* **si bro** – Developer Laravel & Kotlin (project owner)
