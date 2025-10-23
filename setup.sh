#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "$0")" && pwd)"
cd "$PROJECT_DIR"

say(){ printf "%b\n" "$*"; }

say "[1/9] Cek Docker & Compose..."
command -v docker >/dev/null 2>&1 || { say "❌ Docker belum terpasang."; exit 1; }
docker compose version >/dev/null 2>&1 || { say "❌ Docker Compose plugin belum tersedia."; exit 1; }

say "[2/9] Siapkan .env.docker..."
if [ ! -f ".env.docker" ]; then
  if [ -f ".env.docker.example" ]; then
    cp .env.docker.example .env.docker
    say "✅ .env.docker dibuat dari .env.docker.example"
  else
    say "❌ Tidak menemukan .env.docker maupun .env.docker.example"; exit 1
  fi
fi

# Samakan nilai penting agar match service "db" & port Nginx
awk -v H="DB_HOST=db" -v N="DB_DATABASE=school" -v U="DB_USERNAME=school" -v P="DB_PASSWORD=school" -v URL="APP_URL=http://localhost:8080" '
BEGIN{h=n=u=p=url=0}
$0 ~ /^DB_HOST=/      {print H;   h=1;   next}
$0 ~ /^DB_DATABASE=/  {print N;   n=1;   next}
$0 ~ /^DB_USERNAME=/  {print U;   u=1;   next}
$0 ~ /^DB_PASSWORD=/  {print P;   p=1;   next}
$0 ~ /^APP_URL=/      {print URL; url=1; next}
{print}
END{
  if(!h)   print H;
  if(!n)   print N;
  if(!u)   print U;
  if(!p)   print P;
  if(!url) print URL;
}
' .env.docker > .env.docker.tmp && mv .env.docker.tmp .env.docker

# Hindari .env lokal menimpa env_file compose
[ -f ".env" ] && rm -f .env

say "[3/9] Import image .tar atau build image..."
IMPORTED=0
if [ -f "./school-stack-app.tar" ]; then
  docker load -i ./school-stack-app.tar
  say "✅ Image 'school-stack-app' ter-import."
  IMPORTED=1
fi

# Build kalau tidak ada image lokal (atau kamu ingin rebuild)
if ! docker image inspect school-stack-app >/dev/null 2>&1; then
  say "ℹ️ Image school-stack-app belum ada, build sekarang..."
  docker compose build --pull app
else
  [ "$IMPORTED" -eq 0 ] && say "ℹ️ Image sudah ada. (Lewati build)"
fi

say "[4/9] Jalankan stack..."
docker compose up -d

say "[5/9] APP_KEY..."
# Baca nilai APP_KEY sekarang (kalau tidak ada, anggap kosong)
CUR_KEY="$(grep -E '^APP_KEY=' .env.docker 2>/dev/null | cut -d= -f2- || true)"
if [ -z "${CUR_KEY:-}" ]; then
  KEY="$(docker compose run --rm --no-deps app php artisan key:generate --show | tr -d '\r\n' || true)"
  if [ -n "${KEY:-}" ]; then
    awk -v NEW="APP_KEY=${KEY}" '
      BEGIN{found=0}
      /^APP_KEY=/ {print NEW; found=1; next}
      {print}
      END{if(found==0) print NEW}
    ' .env.docker > .env.docker.tmp && mv .env.docker.tmp .env.docker
    say "   • APP_KEY diset."
  else
    say "   ⚠️ Gagal generate APP_KEY otomatis. Isi manual di .env.docker"
  fi
  docker compose up -d app
else
  say "   • APP_KEY sudah ada."
fi

say "[6/9] Install dependency Composer (dalam container)..."
docker compose exec app bash -lc 'composer install --no-interaction --prefer-dist'

say "[7/9] Tunggu DB siap..."
i=0
until docker compose exec -T db sh -c "mariadb-admin ping -h 127.0.0.1 -uroot -proot --silent" >/dev/null 2>&1; do
  i=$((i+1)); [ $i -gt 60 ] && { say "❌ DB belum siap setelah 60s"; docker compose logs db --tail=100; exit 1; }
  sleep 1
done
say "   • DB siap."

say "[7b/9] Tunggu Redis siap..."
j=0
until docker compose exec -T redis sh -c "redis-cli PING" >/dev/null 2>&1; do
  j=$((j+1)); [ $j -gt 60 ] && { say "❌ Redis belum siap setelah 60s"; docker compose logs redis --tail=100; exit 1; }
  sleep 1
done
say "   • Redis siap."

say "[8a/9] Perbaiki permission storage/bootstrap..."
docker compose exec app bash -lc '
  mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache &&
  chown -R www-data:www-data storage bootstrap/cache &&
  find storage bootstrap/cache -type d -exec chmod 775 {} \; &&
  find storage bootstrap/cache -type f -exec chmod 664 {} \;
' || true

say "[8/9] Generate migration untuk session/cache jika diperlukan..."
SESSION_DRIVER="$(grep -E '^SESSION_DRIVER=' .env.docker | cut -d= -f2- || true)"
CACHE_STORE="$(grep -E '^CACHE_STORE=' .env.docker | cut -d= -f2- || true)"
docker compose exec app php artisan config:clear || true

# Jika pakai database untuk session/cache, buatkan migration-nya (idempotent, aman diulang)
if [ "${SESSION_DRIVER:-}" = "database" ]; then
  docker compose exec app php artisan session:table || true
fi
if [ "${CACHE_STORE:-}" = "database" ]; then
  docker compose exec app php artisan cache:table || true
fi

say "   • Migrate schema..."
docker compose exec app php artisan migrate --force
docker compose exec app php artisan storage:link || true

say "   • Jalankan seeder..."
docker compose exec app php artisan db:seed --force || true

say "[9/9] Status:"
docker compose ps
say "\n🎉 Selesai. Buka: http://localhost:8080"
