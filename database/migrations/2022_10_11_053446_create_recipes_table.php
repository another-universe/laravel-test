<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipes', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('title', 150);
            $table->string('short_description', 255)->nullable();
            $table->text('text');
            $table->bigInteger('in_favorites')->default(0);
            $table->bigInteger('times_shared')->default(0);
            $table->timestampsTz(6);
            $table->unique(['user_id', 'title']);
            $table->foreign('user_id')->on('users')->references('id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
