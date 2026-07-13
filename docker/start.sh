#!/usr/bin/env bash
# Container entrypoint for Render — keep this resilient and loud in logs.
set -eu

cd /var/www/html

echo "==> Laravel boot on Render"
echo "PORT=${PORT:-8000}"
echo "APP_ENV=${APP_ENV:-}"
echo "DB_CONNECTION=${DB_CONNECTION:-}"

# Strip accidental quotes from secrets pasted in the dashboard
if [ -n "${APP_KEY:-}" ]; then
  APP_KEY="$(printf '%s' "$APP_KEY" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")"
  export APP_KEY
fi

if [ -z "${APP_KEY:-}" ]; then
  echo "ERROR: APP_KEY is missing. Set it in Render Environment."
  exit 1
fi

# Blueprint / dashboard may expose DATABASE_URL instead of DB_URL
if [ -n "${DATABASE_URL:-}" ] && [ -z "${DB_URL:-}" ]; then
  export DB_URL="$DATABASE_URL"
  echo "==> Mapped DATABASE_URL -> DB_URL"
fi

if [ -z "${DB_URL:-}" ]; then
  echo "ERROR: DB_URL is missing. Set External Database URL from Postgres on Render."
  exit 1
fi

export DB_CONNECTION="${DB_CONNECTION:-pgsql}"
export DB_SSLMODE="${DB_SSLMODE:-require}"

# Show host only (no password) so logs are diagnosable
DB_HOST_HINT="$(printf '%s' "$DB_URL" | sed -E 's#.*@([^/:+]+).*#\1#')"
echo "==> DB host: ${DB_HOST_HINT}"

# Internal-only hosts look like "dpg-xxxx-a" with no domain — they often fail DNS.
# External URL looks like "dpg-xxxx-a.oregon-postgres.render.com"
case "$DB_HOST_HINT" in
  *.render.com|*.render.internal) ;;
  dpg-*)
    echo "ERROR: DB_URL is using Render INTERNAL hostname (${DB_HOST_HINT})."
    echo "Fix: Postgres → Connect → copy External Database URL into DB_URL and DATABASE_URL."
    echo "It must contain something like '.oregon-postgres.render.com' (region may differ)."
    exit 1
    ;;
esac

# Ensure sslmode=require on the URL for external Render Postgres
case "$DB_URL" in
  *sslmode=*) ;;
  *)
    case "$DB_URL" in
      *\?*) export DB_URL="${DB_URL}&sslmode=require" ;;
      *)    export DB_URL="${DB_URL}?sslmode=require" ;;
    esac
    echo "==> Appended sslmode=require to DB_URL"
    ;;
esac

php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

echo "==> Running migrations..."
php artisan migrate --force --no-interaction

echo "==> Seeding (first boot only)..."
php -r '
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
try {
    if (!\App\Models\Profile::query()->exists()) {
        $kernel->call("db:seed", ["--force" => true]);
        echo "Seeded portfolio data.\n";
    } else {
        echo "Seed skipped (data already present).\n";
    }
} catch (Throwable $e) {
    fwrite(STDERR, "Seed warning: " . $e->getMessage() . "\n");
}
'

PORT="${PORT:-8000}"
echo "==> Starting server on 0.0.0.0:${PORT}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
