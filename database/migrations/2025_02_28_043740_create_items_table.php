<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_type_id')->constrained();
            $table->foreignId('item_sub_type_id')->constrained();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('body')->nullable();
            $table->text('images')->nullable();
            $table->text('instructions')->nullable();
            $table->string('part_number')->nullable();
            $table->boolean('has_rare_parts')->default(false);
            $table->text('parts_list')->nullable();
            $table->string('studio_file')->nullable();
            $table->string('studio_thumbnail')->nullable();
            $table->text('flavor_text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
