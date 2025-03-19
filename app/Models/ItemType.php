<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $fillable = [
        'name',
        'name_plural',
    ];

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function itemSubTypes()
    {
        return $this->hasMany(ItemSubType::class);
    }

    public function styles()
    {
        return $this->hasMany(Style::class);
    }
}
