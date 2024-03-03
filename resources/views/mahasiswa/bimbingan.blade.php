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
        <div class="py-5 inline sm:flex items-center px-4">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                    Data Bimbingan Akademik
                    <x-table :data="collect($kp->bimbingans->where('tipe', 'dosen'))->values()" :filterFields="'[\'tanggal\',\'isi\', \'status\']'" itemperpage="10">
                        <x-slot name="newData">
                            <div class="inline text-end">
                                <p class="dark:text-gray-300 text-sm">
                                    Data : {{count($kp->bimbingans->where('tipe', 'dosen'))}}/7
                                </p>
                                <p class="dark:text-gray-300 text-sm">
                                    Disetujui : {{ count($kp->bimbingans->where(['tipe' => 'dosen', 'status' => 'done'])) }}/7
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
                                    <td class="px-0 py-2 whitespace-nowrap text-center text-xs sm:text-sm font-medium w-fit">
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
                    @if(count($kp->bimbingans->where('tipe','dosen')) < 7)
                    <x-button tag="button" color="success" class="float-end mt-2"
                        x-on:click.prevent="tipe='dosen';$dispatch('open-modal', 'createData');selectedBimbingan=''"
                    >
                        Tambah Data Baru
                    </x-button>
                    @endif
                </div>
            </div>
            <div class="w-full mx-auto sm:px-6 lg:px-8 overflow-x-auto">
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
            </div>
        </div>
        
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
                    <x-form-text
                        label="Tipe Bimbingan" 
                        name="tipe" 
                        readonly="true"
                        x-bind:value="selectedBimbingan ? selectedBimbingan.tipe : tipe"
                        id="tipe"
                        :error="$errors->first('tipe')"
                    />
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
                        <x-button type="submit" tag="button" color="success" x-on:click="$dispatch('close')" x-show="tipe">
                            Submit
                        </x-button>
                    </div>
                </form>
                {{-- end input data pembimbing lapangan --}}
            </div>
        </x-modal>
    </div>
    <script>
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