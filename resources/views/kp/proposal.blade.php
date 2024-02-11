<x-app-layout>
    <div class="py-5">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <x-table :data="$proposals" :filterFields="'[\'kp.mahasiswa.nomor_induk\',\'kp.mahasiswa.name\', \'kp.judul\', \'kp.status\']'">
                    <x-slot name="newData">
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIM</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Judul KP</th>
                            <th scope="col" class="px-0 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Jumlah Revisi</th>
                            <th scope="col" class="px-0 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Status Proposal</th>
                            <th scope="col" class="px-0 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Action</th>
                        </tr>
                    </x-slot>

                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="7" class="text-center py-4 text-white">No data available</td>
                        </tr>
                        <template x-for="(proposal, index) in paginatedData" :key="index">
                            <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                <td x-text="proposal.number" class="px-1 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="proposal.kp.mahasiswa.nomor_induk" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="proposal.kp.mahasiswa.name" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="proposal.kp.metadata ? proposal.kp.metadata.judul : 'Belum diisi'" class="px-1 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="proposal.revisi_count" class="px-0 py-4 text-center text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="proposal.status ? proposal.status : 'Belum mengumpulkan proposal'" class="px-0 py-4 text-center whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-0 py-2 whitespace-nowrap text-center text-sm font-medium w-fit">
                                    <x-button tag="a" href="#" color="success"
                                        x-data="{ detailRoute: '{{ route('kordinator.kp.proposal', ['id' => ':id']) }}' }"
                                        x-bind:href="detailRoute.replace(':id', proposal.id)"
                                        x-show="proposal.status =='awaited'"
                                    >
                                        Kelola Proposal
                                    </x-button>
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>
    </div>
</x-app-layout>