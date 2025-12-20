<?php
// database/migrations/2025_12_19_000000_create_carousels_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // chemin de l'image
            $table->string('lien')->nullable(); // si la pub a un lien
            $table->integer('ordre')->default(0); // ordre dans le carrousel
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carousels');
    }
};
