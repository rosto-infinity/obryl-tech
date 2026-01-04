<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Obtenir l'URL d'une image privée
     */
    public static function getUrl(string $path, string $disk = 'private'): string
    {
        if (empty($path)) {
            return asset('images/placeholder.png');
        }

        // Si c'est déjà une URL complète
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // Générer une URL temporaire signée (valable 24h)
        try {
            return Storage::disk($disk)->temporaryUrl(
                $path,
                now()->addDay(),
                ['ResponseContentType' => 'image/jpeg']
            );
        } catch (\Exception $e) {
            return asset('images/placeholder.png');
        }
    }

    /**
     * Obtenir l'URL d'une image avec fallback
     */
    public static function getUrlWithFallback(
        ?string $path,
        string $disk = 'private',
        string $fallback = 'images/placeholder.png'
    ): string {
        if (empty($path)) {
            return asset($fallback);
        }

        return self::getUrl($path, $disk);
    }

    /**
     * Vérifier si le fichier existe
     */
    public static function exists(string $path, string $disk = 'private'): bool
    {
        return Storage::disk($disk)->exists($path);
    }

    /**
     * Obtenir plusieurs URLs
     */
    public static function getUrls(array $paths, string $disk = 'private'): array
    {
        return array_map(
            fn($path) => self::getUrl($path, $disk),
            $paths
        );
    }
}
