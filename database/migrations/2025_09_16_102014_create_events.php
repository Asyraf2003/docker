<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Judul multi-bahasa
            $table->string('title_id');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();

            // Lokasi multi-bahasa
            $table->string('place_id')->nullable();
            $table->string('place_en')->nullable();
            $table->string('place_ar')->nullable();

            // Waktu event
            $table->timestamp('event_date')->index();

            // Link detail agenda
            $table->string('link_url')->nullable();

            // Status publikasi
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('events');
    }
};
