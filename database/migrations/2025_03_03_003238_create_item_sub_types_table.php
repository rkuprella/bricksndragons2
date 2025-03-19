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
        Schema::create('item_sub_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_plural')->nullable();
            $table->foreignId('item_type_id')->constrained()->onDelete('cascade');
            $table->integer('priority')->default(50);
            $table->boolean('collection')->default(false);
            $table->string('icon_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_sub_types');
    }
};
