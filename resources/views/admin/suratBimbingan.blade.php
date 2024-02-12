<x-app-layout>
    <div class="py-5 flex items-center">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="text-center text-white">
                    List KP yang melewati tahap persetujuan proposal
                </div>
                <x-table :data="$kps" :filterFields="'[\'metadata.judul\',\'mahasiswa.name\', \'surat_bimbingan.status_pengambilan\', \'mahasiswa.nomor_induk\']'">
                    <x-slot name="newData">
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-2 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIM Mahasiswa</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Mahasiswa</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Judul KP</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Pembimbing</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Pengambilan Surat Bimbingan</th>
                            <th scope="col" class="px-0 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Tanggal Pengambilan</th>
                        </tr>
                    </x-slot>

                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="7" class="text-center py-4 text-white">No data available</td>
                        </tr>
                        <template x-for="(kp, index) in paginatedData" :key="index">
                            <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                <td x-text="kp.number" class="px-2 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.mahasiswa.nomor_induk" class="px-2 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.mahasiswa.name" class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.metadata.judul" class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="kp.pembimbing.name" class="px-1 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200 flex items-center justify-center">
                                    <input 
                                        class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" 
                                        type="checkbox" 
                                        x-bind:checked="kp.surat_bimbingan?.status_pengambilan"
                                        x-on:change="updateSuratBimbingan(kp.id, $event)"
                                    >
                                </td>
                                <td x-text="kp.surat_bimbingan?.status_pengambilan ? kp.surat_bimbingan?.tanggal_pengambilan : ''" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>
    </div>
    <script>
        function updateSuratBimbingan(id, event) {
            fetch(`/admin/suratbimbingan/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
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
