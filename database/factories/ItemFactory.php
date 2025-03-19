<?php

namespace Database\Factories;

use App\Models\ItemSubType;
use App\Models\ItemType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $itemType = ItemType::inRandomOrder()->first()->name;
        return [
            'name' => fake()->name(),
            'item_type_id' => ItemType::where('name', $itemType)->first()->id,
            'item_sub_type_id' => ItemSubType::where('item_type_id', ItemType::where('name', $itemType)->first()->id)->inRandomOrder()->first()->id,
            'user_id' => User::first()->id,
            'slug' => fake()->slug(),
        ];
    }
}
