<?php

/**
 * Processes the hero portrait: crops, resizes, and places it on a
 * palette-matched canvas without touching the subject.
 */

$source = $argv[1] ?? null;
$destination = $argv[2] ?? null;

if (! $source || ! $destination || ! is_file($source)) {
    fwrite(STDERR, "Usage: php process-profile-photo.php <source> <destination>\n");
    exit(1);
}

$offWhite = [246, 245, 248];
$secondaryEmphasis = [237, 234, 243];
$purple25 = [243, 240, 248];

$extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));

$image = match ($extension) {
    'png' => @imagecreatefrompng($source) ?: @imagecreatefromjpeg($source),
    'jpg', 'jpeg' => imagecreatefromjpeg($source),
    'webp' => imagecreatefromwebp($source),
    default => @imagecreatefromjpeg($source) ?: @imagecreatefrompng($source),
};

if (! $image) {
    fwrite(STDERR, "Unsupported or unreadable image.\n");
    exit(1);
}

$width = imagesx($image);
$height = imagesy($image);

// Only replace backdrop along the outer rim (avoids touching skin/hair)
$rim = (int) max(12, min($width, $height) * 0.06);
$cornerSamples = [];
foreach ([[0, 0], [$width - 1, 0], [0, $height - 1], [$width - 1, $height - 1]] as [$x, $y]) {
    $color = imagecolorat($image, $x, $y);
    $cornerSamples[] = [($color >> 16) & 0xFF, ($color >> 8) & 0xFF, $color & 0xFF];
}
$bg = [
    (int) round(array_sum(array_column($cornerSamples, 0)) / 4),
    (int) round(array_sum(array_column($cornerSamples, 1)) / 4),
    (int) round(array_sum(array_column($cornerSamples, 2)) / 4),
];

$isRim = static function (int $x, int $y, int $w, int $h, int $rim): bool {
    return $x < $rim || $y < $rim || $x >= $w - $rim || $y >= $h - $rim;
};

for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        if (! $isRim($x, $y, $width, $height, $rim)) {
            continue;
        }

        $color = imagecolorat($image, $x, $y);
        $r = ($color >> 16) & 0xFF;
        $g = ($color >> 8) & 0xFF;
        $b = $color & 0xFF;

        $distance = sqrt(($r - $bg[0]) ** 2 + ($g - $bg[1]) ** 2 + ($b - $bg[2]) ** 2);
        if ($distance > 40) {
            continue;
        }

        $blend = min(1, 1 - ($distance / 40));
        $target = $offWhite;
        $nr = (int) round($r * (1 - $blend) + $target[0] * $blend);
        $ng = (int) round($g * (1 - $blend) + $target[1] * $blend);
        $nb = (int) round($b * (1 - $blend) + $target[2] * $blend);
        imagesetpixel($image, $x, $y, imagecolorallocate($image, $nr, $ng, $nb));
    }
}

$cropWidth = (int) round($width * 0.78);
$cropHeight = (int) round($height * 0.94);
$cropX = (int) round(($width - $cropWidth) / 2);
$cropY = (int) round($height * 0.02);

$cropped = imagecrop($image, [
    'x' => $cropX,
    'y' => $cropY,
    'width' => $cropWidth,
    'height' => $cropHeight,
]);

if ($cropped === false) {
    fwrite(STDERR, "Crop failed.\n");
    exit(1);
}

$outputSize = 640;
$resized = imagescale($cropped, $outputSize, $outputSize, IMG_BILINEAR_FIXED);

$canvasSize = 720;
$padding = (int) (($canvasSize - $outputSize) / 2);
$canvas = imagecreatetruecolor($canvasSize, $canvasSize);

for ($y = 0; $y < $canvasSize; $y++) {
    $t = $y / $canvasSize;
    $r = (int) round($purple25[0] * (1 - $t) + $secondaryEmphasis[0] * $t);
    $g = (int) round($purple25[1] * (1 - $t) + $secondaryEmphasis[1] * $t);
    $b = (int) round($purple25[2] * (1 - $t) + $secondaryEmphasis[2] * $t);
    imageline($canvas, 0, $y, $canvasSize, $y, imagecolorallocate($canvas, $r, $g, $b));
}

imagecopy($canvas, $resized, $padding, $padding, 0, 0, $outputSize, $outputSize);

$dir = dirname($destination);
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}

imagejpeg($canvas, $destination, 92);

imagedestroy($image);
imagedestroy($cropped);
imagedestroy($resized);
imagedestroy($canvas);

echo "Saved: {$destination}\n";
