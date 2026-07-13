<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo 'mailer=' . config('mail.default') . PHP_EOL;
echo 'host=' . config('mail.mailers.smtp.host') . PHP_EOL;
echo 'port=' . config('mail.mailers.smtp.port') . PHP_EOL;
echo 'user=' . config('mail.mailers.smtp.username') . PHP_EOL;
echo 'pass_set=' . (filled(config('mail.mailers.smtp.password')) ? 'yes' : 'no') . PHP_EOL;
echo 'pass_len=' . strlen((string) config('mail.mailers.smtp.password')) . PHP_EOL;
echo 'from=' . config('mail.from.address') . PHP_EOL;
echo 'to=' . config('mail.contact_to') . PHP_EOL;
