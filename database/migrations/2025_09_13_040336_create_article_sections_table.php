<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('article_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('paragraph');
            $table->longText('body_id')->nullable();
            $table->longText('body_en')->nullable();
            $table->longText('body_ar')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt_id')->nullable();
            $table->string('image_alt_en')->nullable();
            $table->string('image_alt_ar')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->fullText(['body_id','body_en','body_ar']);
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('article_sections');
    }
};
