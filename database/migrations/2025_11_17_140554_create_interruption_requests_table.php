<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('interruption_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('residence_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->string('status')->default('en_attente');
            $table->string('type_compte');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('interruption_requests');
    }
};
