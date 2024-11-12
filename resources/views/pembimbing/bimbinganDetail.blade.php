<x-app-layout>
    <div x-data="{tipe:'', selectedBimbingan: ''}">
        <div class="py-5 inline sm:flex items-center px-4">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                    Data Bimbingan
                    <x-table :data="$kp->bimbingans" :filterFields="'[\'tanggal\',\'isi\', \'status\']'" itemperpage="10">
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
                                            x-on:click.prevent="selectedBimbingan=bimbingan;"
                                        >
                                            Detail
                                        </x-button>
                                    </td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-table>
                    {{-- @if(count($kp->bimbingans->where('tipe','dosen')) < 7)
                    <x-button tag="button" color="success" class="float-end mt-2"
                        x-on:click.prevent="tipe='dosen';$dispatch('open-modal', 'createData');selectedBimbingan=''"
                    >
                        Tambah Data Baru
                    </x-button>
                    @endif --}}
                </div>
            </div>
            <div class="w-full mx-auto sm:px-6 lg:px-8 overflow-x-auto">
                <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
                    Bimbingan Details
                    <div class="text-start">
                        <p>
                            Tanggal Bimbingan: <span x-text="selectedBimbingan.tanggal ? selectedBimbingan.tanggal.substr(0, 10) : ''"></span>
                        </p>
                        <p>
                            Isi Bimbingan: <span x-text="selectedBimbingan.isi"></span>
                        </p>
                        <p>
                            Status Bimbingan: <span x-text="selectedBimbingan.status"></span>
                        </p>
                    </div>
                    <x-button tag="button" color="success"
                        x-on:click.prevent="tipe='dosen';$dispatch('open-modal', 'setujuiBimbingan');"
                        x-show="selectedBimbingan != '' && selectedBimbingan.status != 'done'"
                    >
                        Setujui Bimbingan
                    </x-button>
                    {{-- <x-button 
                        tag="button"
                        color="success"
                        x-on:click.prevent="selectedBimbingan=bimbingan;"
                        x-show="selectedBimbingan"
                    >
                        Setujui Bimbingan
                    </x-button> --}}
                </div>
            </div>
        </div>
        {{-- modal input data --}}
        <x-modal name="setujuiBimbingan" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Konfirmasi Setujui Data Bimbingan?
                </div>
                <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <form :action="`{{ route('pembimbing.bimbingan.approve', '') }}/${selectedBimbingan.id}`" @submit.prevent="submitRequest">
                        @csrf
                        @method('PATCH')
                        <x-button type="submit" tag="button" color="success">
                            Konfirmasi
                        </x-button>
                    </form>
                </div>
            </div>
        </x-modal>
        <script>
            function submitRequest(e) {
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
                            text: 'Permintaan berhasil disimpan',
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
                    } else if(data && data.hasOwnProperty('message')){
                        let messages = Object.values(message);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Got Message From Server',
                            text: errorMessages
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
    </div>
</x-app-layout>