<?php

namespace App\Services;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use SplFileInfo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Filesystem as MediaFilesystem;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

class MediaService
{
    public function findMediaType($extenstion)
    {
        $mediaTypes = config('eshop_pro.type');

        foreach ($mediaTypes as $mainType => $mediaType) {
            if (in_array(strtolower($extenstion), $mediaType['types'])) {
                return [$mainType, $mediaType['icon']];
            }
        }
        return false;
    }

    public function getImageUrl($path, $image_type = '', $image_size = '', $file_type = 'image', $const = 'MEDIA_PATH')
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Always return placeholder for empty path
        if (empty($path)) {
            return $this->placeholderUrl();
        }

        $pathParts = explode('/', $path);
        $subdirectory = implode("/", array_slice($pathParts, 0, -1));
        $image_name = end($pathParts);
        $file_main_dir = str_replace('\\', '/', public_path(config('constants.' . $const) . $subdirectory));

        if ($file_type == 'image') {
            $types = ['thumb', 'cropped'];
            $sizes = ['md', 'sm'];

            if (in_array(strtolower($image_type), $types) && in_array(strtolower($image_size), $sizes)) {
                $filepath = $file_main_dir . '/' . $image_type . '-' . $image_size . '/' . $image_name;

                if (File::exists($filepath)) {
                    return asset(config('constants.' . $const) . '/' . $path);
                } elseif (File::exists($file_main_dir . '/' . $image_name)) {
                    return asset(config('constants.' . $const) . '/' . $path);
                } else {
                    return $this->placeholderUrl();
                }
            } else {
                if (File::exists($file_main_dir . '/' . $image_name)) {
                    return asset(config('constants.' . $const) . '/' . $path);
                } else {
                    return $this->placeholderUrl();
                }
            }
        } else {
            $file = new SplFileInfo($file_main_dir . '/' . $image_name);
            $ext = $file->getExtension();
            $media_data = $this->findMediaType($ext);

            if (is_array($media_data) && isset($media_data[1])) {
                $imagePlaceholder = $media_data[1];
            } else {
                return $this->placeholderUrl();
            }

            $filepath = str_replace('\\', '/', public_path($imagePlaceholder));
            if (File::exists($filepath)) {
                return asset($imagePlaceholder);
            } else {
                return $this->placeholderUrl();
            }
        }
    }

    public function removeMediaFile($path, $disk)
    {
        $mediaFileSystem = app(MediaFilesystem::class);
        $filesystem = app(FilesystemFactory::class);
        $fileRemover = new CustomFileRemover($mediaFileSystem, $filesystem);

        if ($disk == 's3') {
            $path = implode('/', array_slice(explode('/', $path), -2));
        }

        $fileRemover->removeFile($path, $disk);
    }

    public function dynamic_image($image, $width, $quality = 75)
    {
        $sourceUrl = $this->normalizeImageUrl($image);

        $cached = $this->cachedDynamicImagePath($sourceUrl, $width, $quality);
        if ($cached !== null && is_file($cached['absolute'])) {
            return $cached['url'];
        }

        return route('front_end.dynamic_image', [
            'url' => $sourceUrl,
            'width' => $width,
            'quality' => $quality,
        ]);
    }

    public function cachedDynamicImagePath($sourceUrl, $width, $quality)
    {
        if (empty($sourceUrl)) {
            return null;
        }
        $path = parse_url($sourceUrl, PHP_URL_PATH) ?? '';
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION)) ?: 'jpg';
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
            $ext = 'jpg';
        }
        $hash = md5($sourceUrl . '|' . intval($width) . '|' . intval($quality));
        $rel = 'cache/dynamic_image/' . substr($hash, 0, 2) . '/' . $hash . '.' . $ext;
        return [
            'relative' => $rel,
            'absolute' => public_path('storage/' . $rel),
            'url'      => asset('storage/' . $rel),
        ];
    }

    /**
     * Build a clean public URL for an image stored in storage.
     * Always returns a valid URL — falls back to placeholder image.
     */
    public function getMediaImageUrl($image, $const = 'MEDIA_PATH')
    {
        if (empty($image)) {
            return $this->placeholderUrl();
        }

        // Already full URL
        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        // Clean relative path — ensure no double slashes and no leading /
        $basePath = rtrim(config('constants.' . $const), '/');
        $normalized = ltrim($image, '/');
        $absolutePath = public_path($basePath . '/' . $normalized);

        if (File::exists($absolutePath)) {
            return asset($basePath . '/' . $normalized);
        }

        return $this->placeholderUrl();
    }

    /**
     * Return a URL to the placeholder image.
     */
    public function placeholderUrl()
    {
        return asset(Config::get('constants.NO_IMAGE'));
    }

    /**
     * Normalize an image value into a full URL safe for the dynamic image route.
     */
    public function normalizeImageUrl($image, $const = 'MEDIA_PATH')
    {
        if (empty($image)) {
            return $this->placeholderUrl();
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        $basePath = rtrim(config('constants.' . $const), '/');
        $normalized = ltrim($image, '/');
        return asset($basePath . '/' . $normalized);
    }

    /**
     * Resolve a relative image path to an absolute filesystem path.
     */
    private function buildPublicFilePath($image, $const = 'MEDIA_PATH')
    {
        $basePath = rtrim(config('constants.' . $const), '/');
        $normalized = ltrim($image, '/');
        return public_path($basePath . '/' . $normalized);
    }
}
