<?php

use App\Models\Category;
use App\Models\Developer;
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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('cover');
            $table->string('title');
            $table->date('release_date');
            $table->integer('price');
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(Developer::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
