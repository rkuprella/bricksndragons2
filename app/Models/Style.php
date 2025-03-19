<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    /** @use HasFactory<\Database\Factories\StyleFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'item_type_id',
        'tags',
        'image',
        'scale',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    protected $casts = [
        'tags' => 'array',
    ];
}
