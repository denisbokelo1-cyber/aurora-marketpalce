<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FixExistingCategoryImages extends Migration
{
    /**
     * Run the migrations.
     * Scans all categories and corrects image/banner paths.
     * Also removes any leading slashes and ensures paths are relative.
     */
    public function up()
    {
        try {
            $mediaPath = rtrim(config('constants.MEDIA_PATH', 'storage/'), '/');
            $placeholder = 'assets/img/no-image.jpg';

            DB::table('categories')->orderBy('id')->chunk(100, function ($categories) use ($mediaPath, $placeholder) {
                foreach ($categories as $category) {
                    $updated = false;

                    // Fix image field
                    if (!empty($category->image)) {
                        $fixedImage = $this->normalizePath($category->image);
                        if ($fixedImage !== $category->image) {
                            DB::table('categories')
                                ->where('id', $category->id)
                                ->update(['image' => $fixedImage]);
                            $updated = true;
                        }
                    }

                    // Fix banner field
                    if (!empty($category->banner)) {
                        $fixedBanner = $this->normalizePath($category->banner);
                        if ($fixedBanner !== $category->banner) {
                            DB::table('categories')
                                ->where('id', $category->id)
                                ->update(['banner' => $fixedBanner]);
                            $updated = true;
                        }
                    }

                    if ($updated) {
                        Log::info("Fixed category #{$category->id}: image/banner paths normalized");
                    }
                }
            });

            // Check storage symlink exists
            $storageLink = public_path('storage');
            $storageTarget = storage_path('app/public');
            if (!File::exists($storageLink)) {
                try {
                    File::link($storageTarget, $storageLink);
                    Log::info('Storage symlink created');
                } catch (\Exception $e) {
                    Log::warning('Could not create storage symlink: ' . $e->getMessage());
                }
            }

            // Ensure cache directory exists
            $cacheDir = storage_path('app/public/cache/dynamic_image');
            if (!File::isDirectory($cacheDir)) {
                File::makeDirectory($cacheDir, 0775, true);
                Log::info('Dynamic image cache directory created');
            }

        } catch (\Exception $e) {
            Log::error('FixExistingCategoryImages migration error: ' . $e->getMessage());
        }
    }

    /**
     * Normalize an image path:
     * - Remove leading slash
     * - Remove double slashes
     * - Remove 'public/' prefix if present
     * - Remove 'storage/' prefix duplication
     */
    private function normalizePath($path)
    {
        // Remove leading /
        $path = ltrim($path, '/');

        // Replace double slashes
        $path = preg_replace('/\/+/', '/', $path);

        // Remove 'public/' prefix if stored accidentally
        if (strpos($path, 'public/') === 0) {
            $path = substr($path, 7);
        }

        // If path starts with 'storage/', keep it as is (MEDIA_PATH = 'storage/')
        // Otherwise leave as-is (relative path)

        return $path;
    }

    /**
     * Reverse the migration.
     */
    public function down()
    {
        // No reversal needed - this only normalizes paths
    }
}
