<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            // Judul multi-bahasa
            $table->string('title_id');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();

            // Deskripsi multi-bahasa
            $table->text('desc_id')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_ar')->nullable();

            // Tanggal pengumuman (mis. hari H acara / tanggal efektif)
            $table->date('event_date')->index();

            // Link tujuan (opsional)
            $table->string('link_url')->nullable();

            // Status publikasi
            $table->boolean('is_published')->default(true)->index();
            $table->timestamp('published_at')->nullable()->index();

            $table->unsignedInteger('sort_order')->default(0)->index();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published','event_date','sort_order']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('announcements');
    }
};
