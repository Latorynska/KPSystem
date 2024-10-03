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
                    <x-button 
                        tag="button"
                        color="success"
                        x-on:click.prevent="selectedBimbingan=bimbingan;"
                        x-show="selectedBimbingan"
                    >
                        Setujui Bimbingan
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>