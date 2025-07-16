# Fudz! 🍽️

**Fudz!** adalah platform web berbasis Laravel yang dirancang untuk membantu pengguna menemukan, memesan, dan merekomendasikan tempat makan terbaik, dengan fitur login sosial, integrasi pembayaran, dan manajemen konten.

---

## 🚀 Fitur Utama

- 🔐 Autentikasi (Login/Daftar), termasuk Google & Facebook
- 💬 Sistem komentar dan ulasan
- 📍 Rekomendasi restoran berdasarkan lokasi & preferensi
- 📊 Dashboard admin untuk manajemen restoran, user, dan transaksi
- 💸 Integrasi pembayaran dengan Payment Gateway
- 🤖 Integrasi AI (Gemini, Dify)
- 📈 Google Analytics

---

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/RanggaCasper/fud.git
cd fud
````

### 2. Install Dependency

```bash
composer install
npm install && npm run dev
```

### 3. Setup File `.env`

```bash
cp .env.example .env
php artisan key:generate
```

Edit konfigurasi `.env` sesuai dengan environment kamu (lihat bagian **Konfigurasi**).

### 4. Jalankan Migrasi & Seeder (Opsional)

```bash
php artisan migrate --seed
```

### 5. Jalankan Server Laravel

```bash
php artisan serve
```

Akses aplikasi di: [http://localhost:8000](http://localhost:8000)

---

## 📁 Konfigurasi Google Service Account (Opsional)

Jika kamu menggunakan integrasi dengan Google Cloud :

1. Buat service account di Google Cloud Console
2. Unduh file JSON (misalnya `service-account.json`), kemudian rename menjadi account.json
3. Simpan file tersebut ke:

```bash
storage/app/private/google/account.json
```

---

## ⚙️ Konfigurasi Environment

Pastikan variabel berikut diatur di `.env`:

```dotenv
APP_NAME="Fudz!"
APP_URL=http://localhost

DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/login/google/callback

FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/login/facebook/callback

TOKOPAY_MERCHANT_ID=your_tokopay_merchant_id
TOKOPAY_SECRET_KEY=your_tokopay_secret_key

MAIL_USERNAME=your_email
MAIL_PASSWORD=your_email_app_password

GOOGLE_ANALYTICS_ID=your_analytics_id
```


---

## 🗂️ Struktur Proyek (Singkat)

```
fud/
├── app/                # Logic utama aplikasi
├── config/             # Konfigurasi Laravel
├── database/           # Seeder & migration
├── public/             # Web root
├── resources/          # View (Blade) & asset
├── routes/             # Routing web/api
├── .env.example        # Template konfigurasi
└── README.md           # Dokumentasi ini
```

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---


## 🙋‍♂️ Kontak

Dikembangkan oleh [@RanggaCasper](https://github.com/RanggaCasper)

---

Terima kasih telah menggunakan **Fudz!** 🙏