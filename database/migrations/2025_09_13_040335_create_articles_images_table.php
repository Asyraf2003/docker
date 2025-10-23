<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('author_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title_id');
            $table->string('title_en');
            $table->string('title_ar');

            $table->string('slug')->unique();
            $table->string('hero_image');

            $table->string('excerpt_id', 300)->nullable();
            $table->string('excerpt_en', 300)->nullable();
            $table->string('excerpt_ar', 300)->nullable();

            $table->string('meta_title_id', 120)->nullable();
            $table->string('meta_title_en', 120)->nullable();
            $table->string('meta_title_ar', 120)->nullable();

            $table->string('meta_desc_id', 250)->nullable();
            $table->string('meta_desc_en', 250)->nullable();
            $table->string('meta_desc_ar', 250)->nullable();

            $table->boolean('is_published')->default(false)->index();
            $table->enum('status', ['draft', 'scheduled', 'published', 'archived'])
                ->default('draft')->index();

            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('scheduled_for')->nullable()->index();

            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_hot')->default(false)->index();
            $table->timestamp('hot_until')->nullable()->index();
            $table->timestamp('pinned_until')->nullable()->index();

            $table->unsignedBigInteger('view_count')->default(0)->index();
            $table->unsignedInteger('comment_count')->default(0)->index();
            $table->unsignedInteger('share_count')->default(0);
            $table->unsignedSmallInteger('reading_time')->default(0); // menit, cached

            $table->timestamps();
            $table->softDeletes();

            $table->fullText(['title_id', 'title_en', 'title_ar', 'slug']);
            $table->index(['status','published_at']);
            $table->index(['is_featured','published_at']);
            $table->index(['is_hot','hot_until']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('articles');
    }
};
