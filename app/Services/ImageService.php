<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageService
{
    /**
     * Delete multiple images from storage
     *
     * @param array|string|null $images
     * @return bool
     */
    public function deleteImages($images): bool
    {
        try {
            if (empty($images)) {
                return true;
            }

            // Convert to array if string
            $imageArray = is_string($images) ? json_decode($images, true) : $images;
            
            if (!is_array($imageArray)) {
                Log::warning('Invalid image data format provided for deletion');
                return false;
            }

            // Filter out any null or empty values
            $validImages = array_filter($imageArray, function($image) {
                return !empty($image) && is_string($image);
            });

            if (empty($validImages)) {
                return true;
            }

            // Delete all images in a single batch
            foreach ($validImages as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to delete images: ' . $e->getMessage());
            return false;
        }
    }
} 