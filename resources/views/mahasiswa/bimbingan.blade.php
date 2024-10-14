<x-app-layout>
    <div x-data="{tipe:'', selectedBimbingan: ''}">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                @if($kp->surat_bimbingan?->status_pengambilan)
                    @if(isset($kp->pembimbing->grup_bimbingan))
                    <p>Silahkan untuk bergabug dengan grup sosial media yang diberikan dosen pembimbing anda</p>
                    <a class="underline text-blue-200" href="{{ $kp->pembimbing->grup_bimbingan->link_grup }}">{{ $kp->pembimbing->grup_bimbingan->link_grup }}</a>
                    @else
                    <p>Silahkan hubungi prodi untuk informasi grup dosen pembimbing</p>
                    @endif
                @else
                <p>Silahkan untuk mengambil surat bimbingan ke prodi untuk melanjutkan ke proses bimbingan</p>
                @endif
            </div>
        </div>
        @if($kp->surat_bimbingan?->status_pengambilan)
        <div class="py-5 inline sm:flex items-center px-4">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                    Data Bimbingan Akademik
                    <x-table :data="collect($kp->bimbingans)->values()" :filterFields="'[\'tanggal\',\'isi\', \'status\']'" itemperpage="10">
                        <x-slot name="newData">
                            <div class="inline text-end">
                                <p class="dark:text-gray-300 text-sm">
                                    Data : {{count($kp->bimbingans)}}/7
                                </p>
                                <p class="dark:text-gray-300 text-sm">
                                    Disetujui : {{ $kp->bimbingans->filter(function($bimbingan) {
                                        return $bimbingan->status === 'done';
                                    })->count() }}/7
                                </p>
                            </div>
                        </x-slot>
                        <x-slot name="header">
                            <tr>
                                <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                                <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Tanggal Bimbingan</th>
                                <th scope="col" class="px-2 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Isi Bimbingan</th>
                                <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Status Bimbingan</th>
                                <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Action</th>
                            </tr>
                        </x-slot>
    
                        <x-slot name="body">
                            <tr x-show="paginatedData.length === 0">
                                <td colspan="7" class="text-center py-4 text-white">No data available</td>
                            </tr>
                            <template x-for="(bimbingan, index) in paginatedData" :key="index">
                                <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                    <td x-text="bimbingan.number" class="px-1 py-4 text-center whitespace-nowrap text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                    <td class="px-2 py-4 text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                        <span x-text="new Date(bimbingan.tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })"></span>
                                    </td>
                                    <td class="px-2 py-4 text-justify text-xs sm:text-sm text-gray-800 dark:text-gray-200" x-text="bimbingan.isi.length > 30 ? bimbingan.isi.slice(0, 30) + '...' : bimbingan.isi"></td>
                                    <td x-text="bimbingan.status" class="px-2 py-4 text-center whitespace-nowrap text-xs sm:text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td class="px-0 py-2 whitespace-nowrap text-center text-xs sm:text-sm font-medium w-fit">
                                        <x-button
                                            tag="button"
                                            color="success"
                                            x-on:click.prevent="selectedBimbingan=bimbingan;$dispatch('open-modal', 'updateData')"
                                        >
                                            Detail
                                        </x-button>
                                    </td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-table>
                    @if(count($kp->bimbingans) < 7)
                    <x-button tag="button" color="success" class="float-end mt-2"
                        x-on:click.prevent="$dispatch('open-modal', 'createData');selectedBimbingan=''"
                    >
                        Tambah Data Baru
                    </x-button>
                    @endif
                </div>
            </div>
            @if($kp->bimbingans->where('status', 'done')->count() >= 7)
                <div class="w-full mx-auto sm:px-6 lg:px-8 overflow-x-auto" x-data="{ laporanFile: '{{ $kp->laporan->file_name ?? '' }}' }" @dragover.prevent @dragenter.prevent @drop.prevent="laporanFile = $event.dataTransfer.files[0].name">
                    <form action="{{ route('mahasiswa.kp.laporanPost') }}" method="POST" enctype="multipart/form-data" @submit.prevent="uploadFile($event)">
                    @csrf
                    @method('POST')
                    <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                        Form Pengumpulan Proposal
                        <div class="flex items-center justify-center w-full" x-show="!laporanFile">
                            <label for="laporanFile" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF (Max 4MB)</p>
                                </div>
                                <input id="laporanFile" name="laporan" type="file" class="hidden" accept=".pdf" @change="laporanFile = $event.target.files[0].name" />
                            </label>
                        </div>
                        <!-- Display file name -->
                        <div class="flex items-center" x-show="laporanFile">
                            <x-button tag="a" href="{{ $kp->laporan ? route('mahasiswa.kp.laporanView',['id' => $kp->laporan->kp_id]) : '#' }}" target="_blank">
                                <span x-text="laporanFile"></span>
                            </x-button>
                            <div class="relative group ml-2">
                                <!-- Tooltip -->
                                <span class="absolute left-10 top-0 transform -translate-y-1/2 mt-1 hidden group-hover:block bg-gray-900 text-white text-xs font-medium px-2 py-1 rounded shadow-sm dark:bg-slate-700 w-32" role="tooltip">
                                    click the file name button to view the file
                                </span>
                                <!-- Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                            </div>
                        </div>
                        {{-- end display file name --}}
                        <div class="flex justify-between mt-2" x-show="laporanFile">
                            <x-button tag="button" color="danger" type="button" @click.prevent="laporanFile = ''">
                                replace
                            </x-button>
                            <x-button tag="button" type="submit" color="success" x-show="laporanFile && laporanFile !== '{{ $laporanFile ?? '' }}'">
                                {{ isset($laporanFile) ? 'ReUpload' : 'Upload'}}
                            </x-button>
                        </div>
                    </div>
                    </form>
                </div>
            @endif
            {{-- <div class="w-full mx-auto sm:px-6 lg:px-8 overflow-x-auto">
                @if(!isset($kp->pembimbing_lapangan_id))
                <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                    <p>Akun Pembimbing Lapangan Anda Belum Tersedia di data KP</p>
                    <p>Silahkan Hubungi Kordinator Kp agar bimbingan lapangan anda dapat disetujui oleh pembimbing lapangan</p>
                </div>
                @endif
                <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                    Data Bimbingan Lapangan
                    <x-table :data="collect($kp->bimbingans->where('tipe', 'lapangan'))->values()" :filterFields="'[\'tanggal\',\'isi\', \'status\']'" itemperpage="10">
                        <x-slot name="newData">
                            <div class="inline text-end">
                                <p class="dark:text-gray-300 text-sm">
                                    Data : {{count($kp->bimbingans->where('tipe', 'lapangan'))}}/10
                                </p>
                                <p class="dark:text-gray-300 text-sm">
                                    Disetujui : {{ count($kp->bimbingans->where(['tipe' => 'lapangan', 'status' => 'done'])) }}/10
                                </p>
                            </div>
                        </x-slot>
                        <x-slot name="header">
                            <tr>
                                <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                                <th scope="col" class="px-2 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Tanggal Bimbingan</th>
                                <th scope="col" class="px-2 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Isi Bimbingan</th>
                                <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Status Bimbingan</th>
                                <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Action</th>
                            </tr>
                        </x-slot>
    
                        <x-slot name="body">
                            <tr x-show="paginatedData.length === 0">
                                <td colspan="7" class="text-center py-4 text-white">No data available</td>
                            </tr>
                            <template x-for="(bimbingan, index) in paginatedData" :key="index">
                                <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                    <td x-text="bimbingan.number" class="px-1 py-4 text-center whitespace-nowrap text-xs sm:text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                    <td class="px-2 py-4 text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                                        <span x-text="new Date(bimbingan.tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })"></span>
                                    </td>
                                    <td class="px-2 py-4 text-justify text-xs sm:text-sm text-gray-800 dark:text-gray-200" x-text="bimbingan.isi.length > 15 ? bimbingan.isi.slice(0, 15) + '...' : bimbingan.isi"></td>
                                    <td x-text="bimbingan.status" class="px-2 py-4 text-center whitespace-nowrap text-xs sm:text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td class="px-0 py-2 whitespace-nowrap text-center text-xs font-medium w-fit">
                                        <x-button
                                            tag="button"
                                            color="success"
                                            x-on:click.prevent="tipe='';selectedBimbingan=bimbingan;$dispatch('open-modal', 'createData')"
                                        >
                                            Detail
                                        </x-button>
                                    </td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-table>
                    @if(count($kp->bimbingans->where('tipe','lapangan')) < 10)
                    <x-button tag="button" color="success" class="float-end mt-2"
                        x-on:click.prevent="tipe='lapangan';$dispatch('open-modal', 'createData');selectedBimbingan='';"
                    >
                        Tambah Data Baru
                    </x-button>
                    @endif
                </div>
            </div> --}}
        </div>
        @endif
        {{-- modal input data --}}
        <x-modal name="createData" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Masukkan Isi Data Bimbingan
                </div>
                {{-- input data pembimbing lapangan --}}
                <form 
                    action={{route('mahasiswa.bimbingan.create')}}
                    method="POST" 
                    @submit.prevent="submitForm"
                >
                    @csrf
                    @method('POST') 
                    <!-- input tipe bimbingan-->
                    {{-- <x-form-text
                        label="Tipe Bimbingan" 
                        name="tipe" 
                        readonly="true"
                        x-bind:value="selectedBimbingan ? selectedBimbingan.tipe : tipe"
                        id="tipe"
                        :error="$errors->first('tipe')"
                    /> --}}
                    <!-- End input tipe bimbingan -->
                    <!-- input tanggal bimbingan-->
                    <x-form-text
                        label="Tanggal Bimbingan" 
                        name="tanggal" 
                        type="date"
                        x-bind:value="selectedBimbingan ? new Date(selectedBimbingan.tanggal).toISOString().split('T')[0] : ''"
                        id="tanggal"
                        :error="$errors->first('tanggal')"
                    />
                    <!-- End input tanggal bimbingan -->
                    <!-- input isi text bimbingan -->  
                    <x-textarea
                        label="Isi Bimbingan" 
                        name="isi" 
                        id="isi"
                        rows="5"
                        x-bind:value="selectedBimbingan ? selectedBimbingan.isi : ''" 
                        {{-- :error="$errors->first('identifikasi_masalah')" --}}
                    />
                    <!-- End input isi text bimbingan -->
                    {{-- <p class="text-xs text-gray-400">
                        *Catatan : Password akan dibuat secara default, untuk username diwajibkan agar menggunakan data unik seperti nomor handphone atau nomor induk
                    </p> --}}
                    <div class="mt-6 flex justify-between">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-button type="submit" tag="button" color="success" x-on:click="$dispatch('close')" x-show="selectedBimbingan ===''">
                            Submit
                        </x-button>
                    </div>
                </form>
                {{-- end input data pembimbing lapangan --}}
            </div>
        </x-modal>
        {{-- modal update data --}}
        <x-modal name="updateData" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Update Data Bimbingan
                </div>
                {{-- input data pembimbing lapangan --}}
                    <form 
                        :action="`{{ route('mahasiswa.bimbingan.update', '') }}/${selectedBimbingan.id}`"
                        method="PATCH" 
                        @submit.prevent="submitForm"
                    >
                    @csrf
                    @method('PATCH') 
                    <!-- input tanggal bimbingan-->
                    <x-form-text
                        label="Tanggal Bimbingan" 
                        name="tanggal" 
                        type="date"
                        x-bind:value="selectedBimbingan ? new Date(selectedBimbingan.tanggal).toISOString().split('T')[0] : ''"
                        id="tanggal"
                        :error="$errors->first('tanggal')"
                    />
                    <!-- End input tanggal bimbingan -->
                    <!-- input isi text bimbingan -->  
                    <x-textarea
                        label="Isi Bimbingan" 
                        name="isi" 
                        id="isi"
                        rows="5"
                        x-bind:value="selectedBimbingan ? selectedBimbingan.isi : ''" 
                        {{-- :error="$errors->first('identifikasi_masalah')" --}}
                    />
                    <!-- End input isi text bimbingan -->
                    <div class="mt-6 flex justify-between">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-button type="submit" tag="button" color="success" x-on:click="$dispatch('close')" x-show="selectedBimbingan.status != 'done'">
                            update
                        </x-button>
                    </div>
                </form>
                {{-- end input data pembimbing lapangan --}}
            </div>
        </x-modal>
    </div>
    <script>
        function uploadFile(e) {
            Swal.fire({
                title: 'Permintaan sedang diproses, mohon tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let form = e.target;
            let formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'File Berhasil diunggah.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.href = response.url;
                    }, 1500);
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data && data.hasOwnProperty('errors')) {
                    let errorMessages = Object.values(data.errors).join('\n');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: errorMessages
                    });
                } else if(data){
                    // console.log(data);
                    // let messages = Object.values(data.message);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Got Message From Server',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred!',
                });
            });
        }
        function submitForm(e) {
            Swal.fire({
                title: 'Permintaan sedang diproses, mohon tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let form = e.target;
            let formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data bimbingan berhasil ditambahkan',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data && data.hasOwnProperty('errors')) {
                    let errorMessages = Object.values(data.errors).join('\n');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: errorMessages
                    });
                } else if(data){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Got Message From Server',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred!',
                });
            });
        }
    </script>
</x-app-layout>