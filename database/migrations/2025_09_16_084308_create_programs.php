<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();

            // Judul multi-bahasa
            $table->string('title_id');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();

            // Deskripsi multi-bahasa
            $table->text('desc_id')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_ar')->nullable();

            $table->boolean('is_published')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('programs');
    }
};
