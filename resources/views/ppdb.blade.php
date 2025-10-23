<x-page.index :title="'PPDB - Formulir Pendaftaran'">
    <div class="max-w-5xl mx-auto px-4 py-10">
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl md:text-3xl font-bold text-center mb-8">Form Pendaftaran Siswa Baru</h1>

        <form x-data="{ files: {foto:'',akta:'',ijazah:'',kk:''} }"
              method="POST"
              action="{{ route('ppdb.store') }}"
              enctype="multipart/form-data"
              class="bg-white/80 rounded-2xl shadow-sm ring-1 ring-gray-200 p-6 md:p-8 dark:bg-gray-950">
            @csrf

            {{-- honeypot --}}
            <input type="text" name="hp_check" class="hidden" tabindex="-1" autocomplete="off">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Kolom kiri --}}
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-1">NIK <span class="text-red-500">*</span></label>
                        <input name="nik" value="{{ old('nik') }}" required
                               inputmode="numeric" pattern="[0-9]*"
                               class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                        @error('nik')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">NISN</label>
                        <input name="nisn" value="{{ old('nisn') }}"
                               inputmode="numeric" pattern="[0-9]*"
                               class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                        @error('nisn')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                        @error('nama_lengkap')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input name="email" type="email"
                                    value="{{ old('email', Auth::user()->email ?? '') }}"
                                    disabled
                                    class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">No. HP</label>
                            <input name="no_hp" value="{{ old('no_hp') }}"
                                   class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('no_hp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jenis_kelamin" required class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950">
                                <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih</option>
                                @foreach($jenisKelamin as $k => $v)
                                    <option value="{{ $k }}" @selected(old('jenis_kelamin')===$k)>{{ $v }}</option>
                                @endforeach
                            </select>
                            @error('jenis_kelamin')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Agama</label>
                            <select name="agama" class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950">
                                <option value="" {{ old('agama') ? '' : 'selected' }}>Pilih</option>
                                @foreach($agama as $v)
                                    <option value="{{ $v }}" @selected(old('agama')===$v)>{{ $v }}</option>
                                @endforeach
                            </select>
                            @error('agama')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tempat Lahir</label>
                            <input name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                   class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('tempat_lahir')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Lahir</label>
                            <input name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}"
                                   class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('tanggal_lahir')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Asal Sekolah</label>
                        <input name="asal_sekolah" value="{{ old('asal_sekolah') }}"
                               class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                        @error('asal_sekolah')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tahun Lulus</label>
                            <input name="tahun_lulus" value="{{ old('tahun_lulus') }}" maxlength="4"
                                   class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('tahun_lulus')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Program/Pendidikan <span class="text-red-500">*</span></label>
                            <select name="program_pendidikan" required class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950">
                                <option value="" disabled {{ old('program_pendidikan') ? '' : 'selected' }}>Pilih</option>
                                @foreach($program as $v)
                                    <option value="{{ $v }}" @selected(old('program_pendidikan')===$v)>{{ $v }}</option>
                                @endforeach
                            </select>
                            @error('program_pendidikan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Kolom kanan --}}
                <div class="space-y-5">
                    <div x-data="wilayahPicker({
                            src: 'https://www.emsifa.com/api-wilayah-indonesia/api',
                            provInit: @js(old('provinsi')),
                            kabInit:  @js(old('kabupaten')),
                            kecInit:  @js(old('kecamatan')),
                        })"
                        x-init="init()"
                        class="space-y-5">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium mb-1">Provinsi <span class="text-red-500">*</span></label>
                                <select x-model="provId" @change="onProvChange()"
                                        class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950">
                                    <option value="">{{ __('Pilih Provinsi') }}</option>
                                    <template x-for="p in provs" :key="p.id">
                                        <option :value="p.id" x-text="p.name"></option>
                                    </template>
                                </select>
                                <p class="mt-1 text-xs text-gray-500" x-show="loadingP">Memuat provinsi...</p>
                                {{-- kirim nama provinsi ke server --}}
                                <input type="hidden" name="provinsi" :value="provName">
                                @error('provinsi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Kabupaten/Kota <span class="text-red-500">*</span></label>
                                <select x-model="kabId" @change="onKabChange()"
                                        :disabled="!provId"
                                        class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950 disabled:bg-gray-100">
                                    <option value="">{{ __('Pilih Kabupaten/Kota') }}</option>
                                    <template x-for="k in kabs" :key="k.id">
                                        <option :value="k.id" x-text="k.name"></option>
                                    </template>
                                </select>
                                <p class="mt-1 text-xs text-gray-500" x-show="loadingK">Memuat kabupaten/kota...</p>
                                {{-- kirim nama kabupaten ke server --}}
                                <input type="hidden" name="kabupaten" :value="kabName">
                                @error('kabupaten')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium mb-1">Kecamatan <span class="text-red-500">*</span></label>
                                <select x-model="kecId" @change="setKecName()"
                                        :disabled="!kabId"
                                        class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950 disabled:bg-gray-100">
                                    <option value="">{{ __('Pilih Kecamatan') }}</option>
                                    <template x-for="c in kecs" :key="c.id">
                                        <option :value="c.id" x-text="c.name"></option>
                                    </template>
                                </select>
                                <p class="mt-1 text-xs text-gray-500" x-show="loadingC">Memuat kecamatan...</p>
                                {{-- kirim nama kecamatan ke server --}}
                                <input type="hidden" name="kecamatan" :value="kecName">
                                @error('kecamatan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Alamat Lengkap</label>
                                <textarea name="alamat" rows="4"
                                        class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950">{{ old('alamat') }}</textarea>
                                @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nama Ayah</label>
                            <input name="nama_ayah" value="{{ old('nama_ayah') }}"
                                   class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('nama_ayah')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Pekerjaan Ayah</label>
                            <input name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}"
                                   class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('pekerjaan_ayah')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nama Ibu</label>
                            <input name="nama_ibu" value="{{ old('nama_ibu') }}"
                                   class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('nama_ibu')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Pekerjaan Ibu</label>
                            <input name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}"
                                   class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            @error('pekerjaan_ibu')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Penghasilan Wali (Rp)</label>
                        <input name="penghasilan_wali" value="{{ old('penghasilan_wali') }}"
                               inputmode="numeric" pattern="[0-9]*"
                               class="w-full rounded-full border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                        @error('penghasilan_wali')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Upload ringkas + preview nama file via Alpine --}}
                    @php
                        $uploads = [
                            ['name'=>'file_foto','label'=>'Foto Siswa','key'=>'foto'],
                            ['name'=>'file_akta','label'=>'Akta Kelahiran','key'=>'akta'],
                            ['name'=>'file_ijazah','label'=>'Ijazah / SKL','key'=>'ijazah'],
                            ['name'=>'file_kk','label'=>'KK / KTP Wali','key'=>'kk'],
                        ];
                    @endphp

                    @foreach($uploads as $u)
                        <div>
                            <label class="block text-sm font-medium mb-1">{{ $u['label'] }}</label>
                            <div class="flex items-center gap-3">
                                <input type="file" name="{{ $u['name'] }}"
                                       @change="files.{{ $u['key'] }} = $event.target.files[0]?.name || ''"
                                       class="block w-full text-sm file:mr-4 file:rounded-full file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white hover:file:bg-indigo-700 cursor-pointer rounded-xl border-gray-300 focus:ring-2 focus:ring-indigo-500 dark:bg-gray-950" />
                            </div>
                            <p class="mt-1 text-xs text-gray-500" x-text="files.{{ $u['key'] }}"></p>
                            @error($u['name'])<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                <button type="submit"
                        class="w-full md:w-auto px-8 py-3 rounded-full bg-indigo-700 hover:bg-indigo-800 text-white font-semibold shadow-sm">
                    Kirim Pendaftaran
                </button>
                <p class="text-xs text-gray-500 mt-2">Dengan mengirim formulir ini Anda menyetujui kebijakan privasi sekolah.</p>
            </div>
        </form>
    </div>
</x-page.index>
