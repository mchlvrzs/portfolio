#!/usr/bin/env bash
# Runs on every container start (migrate + cache + serve).
set -euo pipefail

cd /var/www/html

echo "Caching Laravel config / routes / views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force --no-interaction

# Seed portfolio content once (skip if a profile already exists)
php -r '
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
if (!\App\Models\Profile::query()->exists()) {
    echo "Seeding portfolio data...\n";
    $kernel->call("db:seed", ["--force" => true]);
} else {
    echo "Profile data already present — skipping seed.\n";
}
'

PORT="${PORT:-8000}"
echo "Starting Laravel on 0.0.0.0:${PORT}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
