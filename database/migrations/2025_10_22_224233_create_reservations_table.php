m<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date_arrivee');
            $table->date('date_depart');
            $table->integer('personnes')->default(1);
            $table->string('reservation_code')->unique();
            $table->string('status')->default('en_attente'); // en_attente, validee, refusee, annulee
            $table->integer('total')->nullable();
            $table->unsignedBigInteger('proprietaire_id');
            $table->unsignedBigInteger('residence_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('proprietaire_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('residence_id')->references('id')->on('residences')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservations');
    }
};