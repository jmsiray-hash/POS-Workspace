<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class PhotoUploader
{
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    public static function store(UploadedFile $file, string $folder): string
    {
        if (! in_array($folder, ['users', 'customers'], true)) {
            throw new RuntimeException('Invalid photo upload destination.');
        }

        if (! $file->isValid()) {
            throw new RuntimeException('The uploaded photo is invalid or has an unsupported image type.');
        }

        $extension = self::MIME_EXTENSIONS[$file->getMimeType()] ?? null;
        if ($extension === null) {
            throw new RuntimeException('The uploaded photo is invalid or has an unsupported image type.');
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $folder;
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the photo upload directory.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $file->move($directory, $filename);

        return 'uploads/' . $folder . '/' . $filename;
    }

    public static function remove(?string $path, string $folder): void
    {
        $prefix = 'uploads/' . $folder . '/';
        if ($path === null || ! str_starts_with($path, $prefix)) {
            return;
        }

        $filename = basename($path);
        $filePath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $filename;
        if (is_file($filePath) && ! unlink($filePath)) {
            throw new RuntimeException('Unable to remove the previous photo.');
        }
    }
}
