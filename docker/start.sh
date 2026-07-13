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
  echo "ERROR: DB_URL is missing. Link the Postgres database in Render."
  exit 1
fi

export DB_CONNECTION="${DB_CONNECTION:-pgsql}"

# Avoid stale cached config from a previous crash
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
    // Do not kill the web process if seed fails — site can still boot
    fwrite(STDERR, "Seed warning: " . $e->getMessage() . "\n");
}
'

PORT="${PORT:-8000}"
echo "==> Starting server on 0.0.0.0:${PORT}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
