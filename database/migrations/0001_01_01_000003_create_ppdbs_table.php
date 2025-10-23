<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ppdbs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade'); // jika user dihapus, data PPDB ikut hilang

            $table->string('nik', 20)->unique();
            $table->string('nisn', 15)->nullable()->unique();
            $table->string('nama_lengkap');
            $table->string('email')->nullable();
            $table->string('no_hp', 30)->nullable();

            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama')->nullable();

            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->string('asal_sekolah')->nullable();
            $table->string('tahun_lulus', 4)->nullable();

            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->text('alamat')->nullable();

            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->unsignedBigInteger('penghasilan_wali')->nullable();

            $table->string('program_pendidikan'); 

            $table->string('file_foto')->nullable();
            $table->string('file_akta')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('file_kk')->nullable();

            $table->enum('status', ['baru','diterima','ditolak'])->default('baru');

            $table->timestamps();
            $table->softDeletes();
            $table->index(['program_pendidikan','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppdbs');
    }
};
