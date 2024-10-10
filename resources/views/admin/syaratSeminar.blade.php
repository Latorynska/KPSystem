<x-app-layout>
    <div class="py-5 flex items-center" x-data="{selectedSeminar:''}">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="text-center text-white">
                    List Pengumpulan Berkas Syarat Seminar
                </div>
                <x-table :data="$kps" :filterFields="'[\'mahasiswa.nomor_induk\',\'mahasiswa.name\', \'metadata.judul_kp\']'">
                    <x-slot name="newData">
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-2 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIM Mahasiswa</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Mahasiswa</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Judul KP</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Laporan KP</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Lembar Persetujuan</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Bebas Tunggakan</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Bebas Pinjaman</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Tanggal Seminar</th>
                        </tr>
                    </x-slot>

                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="8" class="text-center py-4 text-white">No data available</td>
                        </tr>
                        <template x-for="(kp, index) in paginatedData" :key="index">
                            <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                <td x-text="kp.number" class="px-2 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.mahasiswa.nomor_induk" class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.mahasiswa.name" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-200"></td>
                                <td x-text="kp.metadata.judul.length > 30 ? kp.metadata.judul(0, 30) + '...' : kp.metadata.judul" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-200"></td>
                                <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 flex items-center justify-center">
                                    <input 
                                    class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-300 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" 
                                        type="checkbox" 
                                        x-bind:checked="kp.syarat_seminar.laporan_kp"
                                        x-on:change="updateSyaratSeminar(kp.id, 'laporan_kp', $event.target.checked)"
                                    >
                                </td>
                                <td class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-200">
                                    <input 
                                        class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-300 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" 
                                        type="checkbox" 
                                        x-bind:checked="kp.syarat_seminar.lembar_pengesahan"
                                        x-on:change="updateSyaratSeminar(kp.id, 'lembar_pengesahan', $event.target.checked)"
                                    >
                                </td>                         
                                <td class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-200">
                                    <input 
                                        class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-300 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" 
                                        type="checkbox" 
                                        x-bind:checked="kp.syarat_seminar.bebas_tunggakan"
                                        x-on:change="updateSyaratSeminar(kp.id, 'bebas_tunggakan', $event.target.checked)"
                                    >
                                </td>                         
                                <td class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-200">
                                    <input 
                                        class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-300 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" 
                                        type="checkbox" 
                                        x-bind:checked="kp.syarat_seminar.bebas_pinjaman"
                                        x-on:change="updateSyaratSeminar(kp.id, 'bebas_pinjaman', $event.target.checked)"
                                    >
                                </td>
                                <td class="px-0 py-2 whitespace-nowrap text-center text-xs sm:text-sm font-medium w-fit">
                                    <x-button
                                        tag="button"
                                        color="success"
                                        x-on:click.prevent="selectedSeminar=kp.syarat_seminar;$dispatch('open-modal', 'updateTanggal')"
                                    >
                                        Set Tanggal Seminar
                                    </x-button>
                                </td>           
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>
        {{-- modal update data --}}
        <x-modal name="updateTanggal" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Update Tanggal Seminar
                </div>
                {{-- input data pembimbing lapangan --}}
                    <form 
                        {{-- :action="`{{ route('mahasiswa.bimbingan.update', '') }}/${selectedBimbingan.id}`" --}}
                        method="PATCH" 
                        @submit.prevent="submitForm"
                    >
                    @csrf
                    @method('PATCH') 
                    <!-- input tanggal bimbingan-->
                    <x-form-text
                        label="Tanggal Seminar" 
                        name="tanggal" 
                        type="date"
                        x-bind:value="selectedSeminar.tanggal ? new Date(selectedSeminar.tanggal).toISOString().split('T')[0] : ''"
                        id="tanggal"
                        :error="$errors->first('tanggal')"
                    />
                    <!-- End input tanggal bimbingan -->
                    <div class="mt-6 flex justify-between">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-button type="submit" tag="button" color="success" x-on:click="$dispatch('close')">
                            update
                        </x-button>
                    </div>
                </form>
                {{-- end input data pembimbing lapangan --}}
            </div>
        </x-modal>
    </div>
    <script>
        function updateSyaratSeminar(id, field, value) {
            fetch(`/admin/syaratseminar/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    [field]: value
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // console.log(data);
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                });
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: 'Terdapat galat, cek konsol untuk informasi lanjutan'
                });
                console.error('There was an error!', error);
                event.target.checked = !event.target.checked;
            });
        }
    </script>
</x-app-layout>
