<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSubType extends Model
{
    protected $fillable = [
        'name',
        'name_plural',
        'item_type_id',
        'priority',
        'collection',
        'icon_path',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'item_sub_type_id');
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }
}
