<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StudioFileController extends Controller
{
    /**
     * Upload a Studio file for an item
     *
     * @param Request $request
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, Item $item)
    {
        $request->validate([
            'studio_file' => 'required|file|mimes:io|max:10240', // Max 10MB
        ]);

        try {
            $success = $item->uploadStudioFile($request->file('studio_file'));

            if (!$success) {
                return response()->json([
                    'message' => 'Failed to upload Studio file'
                ], 500);
            }

            return response()->json([
                'message' => 'Studio file uploaded successfully',
                'thumbnail_url' => Storage::disk('public')->url($item->studio_thumbnail)
            ]);
        } catch (\Exception $e) {
            Log::error('Studio file upload failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to upload Studio file'
            ], 500);
        }
    }

    /**
     * Download a Studio file
     *
     * @param Item $item
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\JsonResponse
     */
    public function download(Item $item)
    {
        if (!$item->studio_file) {
            return response()->json([
                'message' => 'No Studio file found'
            ], 404);
        }

        try {
            return Storage::disk('public')->download($item->studio_file);
        } catch (\Exception $e) {
            Log::error('Studio file download failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to download Studio file'
            ], 500);
        }
    }
} 