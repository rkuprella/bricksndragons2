<?php

namespace App\Models;

use App\Services\ImageService;
use App\Services\StudioFileService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'item_type_id',
        'item_sub_type_id',
        'user_id',
        'body',
        'images',
        'parts_list',
        'studio_file',
        'studio_thumbnail',
        'instructions',
        'part_number',
        'has_rare_parts',
    ];

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function itemSubType()
    {
        return $this->belongsTo(ItemSubType::class, 'item_sub_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function styles()
    {
        return $this->belongsToMany(Style::class);
    }

    public function themes()
    {
        return $this->belongsToMany(Theme::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Item::class, 'item_module', 'item_id', 'module_id')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function parentItems()
    {
        return $this->belongsToMany(Item::class, 'item_module', 'module_id', 'item_id')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'images' => 'array',
        'has_rare_parts' => 'boolean',
        'parts_list' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            try {
                $imageService = new ImageService();
                $imageService->deleteImages($item->images);

                // Delete Studio files
                if ($item->studio_file) {
                    Storage::disk('public')->delete($item->studio_file);
                }
                if ($item->studio_thumbnail) {
                    Storage::disk('public')->delete($item->studio_thumbnail);
                }
            } catch (\Exception $e) {
                Log::error('Failed to delete files for item ' . $item->id . ': ' . $e->getMessage());
            }
        });
    }
}
