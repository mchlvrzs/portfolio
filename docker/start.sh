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
  echo "ERROR: DB_URL / DATABASE_URL is missing."
  exit 1
fi

export DB_CONNECTION="${DB_CONNECTION:-pgsql}"
export DB_SSLMODE="${DB_SSLMODE:-require}"

# Show host only (no password) so logs are diagnosable
DB_HOST_HINT="$(printf '%s' "$DB_URL" | sed -E 's#.*@([^/:?]+).*#\1#')"
echo "==> DB host: ${DB_HOST_HINT}"

# Linked Render DBs inject an internal host like "dpg-xxxx-a" (no dots).
# Rewrite to external hostname so DNS works from the web service.
# Example: dpg-xxxx-a  ->  dpg-xxxx-a.singapore-postgres.render.com
if ! printf '%s' "$DB_HOST_HINT" | grep -q '\.'; then
  SUFFIX="${RENDER_DB_HOST_SUFFIX:-singapore-postgres.render.com}"
  NEW_HOST="${DB_HOST_HINT}.${SUFFIX}"
  export DB_URL="$(printf '%s' "$DB_URL" | sed "s/@${DB_HOST_HINT}/@${NEW_HOST}/")"
  export DATABASE_URL="$DB_URL"
  echo "==> Rewrote internal DB host to: ${NEW_HOST}"
fi

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
# php artisan serve can handle a few concurrent requests on free tier
export PHP_CLI_SERVER_WORKERS="${PHP_CLI_SERVER_WORKERS:-4}"
echo "==> Starting server on 0.0.0.0:${PORT} (workers=${PHP_CLI_SERVER_WORKERS})"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
