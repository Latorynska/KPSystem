<x-app-layout>
    <div x-data="{selectedPembimbingLapangan: '', selectedKP: ''}">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                <x-table :data="$kps" :filterFields="'[\'mahasiswa.nomor_induk\',\'mahasiswa.name\', \'pembimbing?.name\']'" itemperpage="10">
                    <x-slot name="newData">
                        {{-- <x-button tag="a" color="" class="text-sm ml-4" x-data="{ syncing: false }" x-on:click.prevent="fetchData">
                            <span x-show="syncing">Menyinkronkan...</span>
                            <span x-show="!syncing">Sinkronkan Data</span>
                        </x-button> --}}
    
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIM mahasiswa</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Mahasiswa</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Pembimbing Akademik</th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Bimbingan Akademik</th>
                            {{-- <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Pembimbing Lapangan</th> --}}
                            {{-- <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Bimbingan Lapangan</th> --}}
                            <th scope="col" class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Judul KP</th>
                            <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Action</th>
                        </tr>
                    </x-slot>
    
                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="7" class="text-center py-4 text-white">No data available</td>
                        </tr>
                        <template x-for="(kp, index) in paginatedData" :key="index">
                            <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                <td x-text="kp.number" class="px-2 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.mahasiswa.nomor_induk" class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.mahasiswa.name" class="px-4 py-4 text-start whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.pembimbing ? kp.pembimbing.name : 'belum dipilih'" class="px-4 py-4 text-start whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.bimbingan_count + '/7'" class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                {{-- <td x-text="kp.pembimbing_lapangan ? kp.pembimbing_lapangan.name : 'belum dipilih'" class="px-4 py-4 text-start whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td> --}}
                                {{-- <td x-text="kp.lapangan_bimbingan_count + '/10'" class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td> --}}
                                <td x-text="kp.metadata ? kp.metadata.judul : 'belum diisi'" class="px-1 py-4 text-start text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-2 py-2 whitespace-nowrap text-center text-sm font-medium w-fit">
                                    <a 
                                        class="flex w-full items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700" 
                                        x-data="{ detailRoute: '{{ route('pembimbing.bimbingan.lists.details', ['id' => ':id']) }}' }"
                                        x-bind:href="detailRoute.replace(':id', kp.id)"
                                    >
                                        Kelola Bimbingan
                                    </a>
                                    {{-- <div class="hs-dropdown relative inline-flex">
                                        <button id="hs-dropdown-default" type="button" class="hs-dropdown-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                          Actions
                                          <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                                        </button>
                                        <div class="hs-dropdown-menu hidden transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 min-w-60 bg-white shadow-md rounded-lg p-2 mt-2 divide-y divide-gray-200 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-700" aria-labelledby="hs-dropdown-with-dividers">                                        
                                            <div class="py-2 first:pt-0 last:pb-0">
                                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700" href="#">
                                                    Lihat Bimbingan Akademik
                                                </a>
                                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700" href="#">
                                                    Lihat Bimbingan Lapangan
                                                </a>
                                            </div>
                                        </div>
                                    </div> --}}
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>
        {{-- modal konfirmasi --}}
        <x-modal name="selectPembimbingLapangan" focusable>
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    <span>
                        pilih pembimbing
                    </span>
                </div>
                {{-- <x-table :data="$pembimbing_lapangans" :filterFields="'[\'name\', \'nomor_induk\']'">
                    <x-slot name="newData">
                        <div>
                            <x-button tag="button" color="default" 
                                x-on:click.prevent="$dispatch('open-modal', 'createData')"
                            >
                                Tambah Data Baru
                            </x-button>
                        </div>
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIDN</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Pembimbing</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Email</th>
                            <th scope="col" class="px-0 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Action</th>
                        </tr>
                    </x-slot>
                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="7" class="text-center py-4 text-white">No data available</td>
                        </tr>
                        <template x-for="(pembimbing, index) in paginatedData" :key="index">
                            <tr 
                                class="even:bg-white odd:bg-gray-100 hover:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-700 dark:hover:bg-gray-700"
                                x-on:click.prevent="
                                    selectedPembimbingLapangan = pembimbing;
                                "
                            >
                                <td x-text="pembimbing.number" class="px-1 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.nomor_induk" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.name" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.email" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-0 py-2 whitespace-nowrap text-center text-sm font-medium w-fit">
                                    <button 
                                        type="button" 
                                        class="py-1 px-2 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                        x-on:click.prevent="
                                            selectedPembimbingLapangan = pembimbing;
                                        "
                                    >
                                        Select
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table> --}}
                <p class="text-white">
                    Pembimbing Dipilih : <span x-text="selectedPembimbingLapangan?.name"></span>
                </p>
                @error('pembimbing_id')
                    <p class="text-red-500 text-xs mt-1 ms-1">Silahkan Pilih pembimbing terlebih dahulu</p>
                @enderror
                <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <form 
                    
                        x-data="{ postRoute: '{{ route('kordinator.kp.bimbingan.assign', ['id' => ':id']) }}' }"
                        x-bind:action="postRoute.replace(':id', selectedKP.id)"
                        method="POST" 
                        @submit.prevent="submitForm"
                        >
                        @csrf
                        @method('POST')
                        <input type="hidden" name="pembimbing_id" 
                            x-bind:value="selectedPembimbingLapangan ? selectedPembimbingLapangan.id : ''" 
                        >
                        <x-button type="submit" tag="button" color="success" x-bind:disabled="!selectedPembimbingLapangan.id">
                            Pilih pembimbing dan setujui
                        </x-button>
                    </form>
                </div>
            </div>
        </x-modal>
        
        {{-- modal input pembimbing lapangan data --}}
        
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
                        text: 'Permintaan Berhasil diunggah',
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