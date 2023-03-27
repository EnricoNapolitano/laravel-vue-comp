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
        Schema::create('videogames', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->required();
            $table->text('description')->nullable();
            $table->string('img_url')->nullable();
            $table->enum('platform', ['PC', 'Xbox', 'PlayStation', 'Switch'])->nullable();
            $table->char('pegi', 2)->nullable();
            $table->string('producer', 50)->nullable();
            $table->tinyInteger('vote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videogames');
    }
};
