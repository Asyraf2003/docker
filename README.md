# README.md

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# School Portable (Laravel + Docker)

Stack Laravel yang siap pakai dengan Docker (PHP-FPM, Nginx, MariaDB, Redis) dan skrip **setup.sh** satu klik.

---

## 🧩 Prasyarat

- **Docker** & **Docker Compose plugin**
- **Git**
- (Opsional dev assets) **Node.js + npm**

Cek cepat:
docker --version
docker compose version
git --version

---

## 🚀 Cara Pakai (ambil dari GitHub → jalan)

# 1) Clone repo
git clone https://github.com/Asyraf2003/docker school-portable

cd school-portable

# 2) Jalankan setup otomatis
chmod +x setup.sh
./setup.sh

# 3) Buka aplikasi
# default via Nginx:
# http://localhost:8080

setup.sh akan:
- Membuat `.env.docker` (dari example)
- Import/build image `school-stack-app`
- Generate `APP_KEY`
- Menyalakan container: app, nginx, db, redis
- Menunggu DB & Redis siap
- Memperbaiki permission `storage/` & `bootstrap/cache`
- `migrate --force`, `storage:link`
- Menjalankan seeder otomatis
- Output akhir akan menampilkan status container dan URL akses

---

## ⚙️ Struktur Layanan (docker-compose)

- **app**: PHP 8.3 FPM + ekstensi (pdo_mysql, intl, gd, zip, mbstring, exif, opcache, redis)
- **nginx**: reverse proxy ke `app:9000`, root `/var/www/public`
- **db**: MariaDB 11 (school/school, root root)
- **redis**: Redis 7 (AOF on) — dipakai untuk rate limiting / opsional cache/queue

Port:
- **Nginx:** http://localhost:8080  
- **DB & Redis** tidak diexpose ke host

---

## ⚙️ Konfigurasi Lingkungan

File yang dipakai container: `.env.docker` (dibuat otomatis dari `.env.docker.example`).

Nilai penting (default):

APP_URL=http://localhost:8080

DB_HOST=db
DB_DATABASE=school
DB_USERNAME=school
DB_PASSWORD=school

REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PORT=6379

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=file

Ingin pakai Redis untuk queue atau cache?
- Queue: `QUEUE_CONNECTION=redis`
- Cache: `CACHE_STORE=redis`
- Session: `SESSION_DRIVER=redis`

---

## 💡 Perintah Harian

# Lihat status / log
docker compose ps
docker compose logs -f app
docker compose logs -f nginx
docker compose logs -f db
docker compose logs -f redis

# Masuk container app
docker compose exec app bash

# Start/Stop
docker compose up -d
docker compose down

# Reset total (hapus volume DB/Redis)
docker compose down -v

---

## 🎨 Asset Frontend (opsional)

Laravel akan tetap hidup tanpa Vite di dev, tetapi untuk CSS/JS modern:

# di host (bukan di container)
npm install
npm run dev   # dev server
# atau
npm run build # output ke public/build untuk serve statis

---

## 🧯 Troubleshooting Ringkas

### 1. 404 Nginx / index.php tak terlihat
docker compose restart nginx
docker compose exec nginx sh -lc 'ls -l /var/www/public && (test -f /var/www/public/index.php && echo INDEX_OK || echo INDEX_MISSING)'

### 2. DB timeout saat setup
Pastikan cek di setup.sh menggunakan:
mariadb-admin ... -uroot -proot --silent  (sudah disiapkan)
Cek log:
docker compose logs -f db

### 3. Permission storage/framework/views
docker compose exec app bash -lc 'mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache && chmod -R ug+rw storage bootstrap/cache'

### 4. Redis “connection refused / 127.0.0.1”
Pastikan `.env.docker` → REDIS_HOST=redis
Restart app:
docker compose restart app

### 5. Port 8080 sudah dipakai
Ubah di `docker-compose.yml`:
ports:
  - "8081:80"
Akses:
http://localhost:8081

---

## 📜 Lisensi

Proyek ini memakai Laravel (MIT).  
Lihat berkas LICENSE Laravel untuk detail lisensi kerangka kerja.

---

## 🤝 Kredit

- Laravel & komunitasnya  
- Nginx, MariaDB, Redis

---

## 🌟 Saran terbaik

- Gunakan `.env.docker.example` sebagai template; **jangan commit kredensial**.  
- Untuk pengembangan, cukup jalankan:
  ./setup.sh  
  dan gunakan perintah `docker compose ...` di atas.
- Untuk **produksi**, buat file compose khusus tanpa bind mount, `npm run build`, dan image final yang sudah `composer install --no-dev`.
