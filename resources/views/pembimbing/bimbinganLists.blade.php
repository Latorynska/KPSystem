<x-app-layout>
    <div class="py-5 flex items-center">
        {{-- metadata --}}
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="text-center text-white">
                    Mahasiswa Bimbingan Anda
                </div>
                <x-table :data="$kps" :filterFields="'[\'metadata.judul\',\'mahasiswa.name\', \'metadata.status\', \'mahasiswa.nomor_induk\']'">
                    <x-slot name="newData">
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIM</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Judul KP</th>
                        </tr>
                    </x-slot>

                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="7" class="text-center py-4 text-white">No data available</td>
                        </tr>
                        <template x-for="(kp, index) in paginatedData" :key="index">
                            <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                <td x-text="kp.number" class="px-1 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.mahasiswa.nomor_induk" class="px-1 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.mahasiswa.name" class="px-1 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.metadata.judul" class="px-1 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>
    </div>
</x-app-layout>
