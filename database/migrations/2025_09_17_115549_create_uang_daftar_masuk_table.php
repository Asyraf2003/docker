<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('uang_daftar_masuk', function (Blueprint $table) {
            $table->id();

            // relasi dasar
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ppdb_id')->nullable()->constrained('ppdbs')->nullOnDelete();

            // info pembayaran
            $table->unsignedBigInteger('amount'); // dalam rupiah
            $table->string('metode')->nullable(); // mis: 'Transfer BRI', 'QRIS'
            $table->string('tujuan')->nullable(); // no.rek/VA/QR

            // bukti & status
            $table->string('bukti_path')->nullable(); // path bukti transfer (jpg/png/webp)
            $table->enum('status', ['pending','verified','rejected'])->default('pending');
            $table->timestamp('paid_at')->nullable();

            // audit
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uang_daftar_masuk');
    }
};
