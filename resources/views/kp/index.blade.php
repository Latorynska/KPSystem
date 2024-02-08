<x-app-layout>
    <div x-data="{ selectedPembimbing: {!! htmlspecialchars(json_encode($kp->pembimbing ?? null)) !!} }">
        <div class="py-5 flex items-center">
            {{-- metadata --}}
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                    {{-- form metadata --}}
                    <div class="w-full mx-auto">
                        <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 h-full">
                            Form Data KP
                            <!-- input Judul KP -->
                            <x-form-text
                                label="Judul KP" 
                                :value="$kp->metadata ? $kp->metadata->judul : ''" 
                                readonly="true"
                            />
                            <!-- End input judul kp-->
                            <!-- input nama instansi -->
                            <x-form-text
                                label="Nama Instansi" 
                                :value="$kp->metadata ? $kp->metadata->instansi : ''"
                                readonly="true"
                            />
                            <!-- End input nama instansi -->
                            <!-- input nama pembimbing lapangan -->
                            <x-form-text
                                label="Nama Pembimbing Lapangan" 
                                :value="$kp->metadata ? $kp->metadata->nama_pembimbing_lapangan : ''" 
                                readonly="true"
                            />
                            <!-- End input nama pembimbing lapangan -->
                            <!-- input nomor pembimbing lapangan -->
                            <x-form-text
                                label="Nomor Telepon Pembimbing Lapangan" 
                                :value="$kp->metadata ? $kp->metadata->nomor_pembimbing_lapangan : ''" 
                                readonly="true"
                            />
                            <!-- End input nomor pembimbing lapangan -->
                            {{-- pilih pembimbing --}}
                            <form action="{{ route('kordinator.kp.details',['id'=>$kp->id]) }}" method="POST" @submit.prevent="submitForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden"
                                name="pembimbing_id"
                                x-bind:value="selectedPembimbing ? selectedPembimbing.id : ''" 
                                value="{{ old('pembimbing_id', $kp->pembimbing_id ?? '')}}"
                            >
                            <x-form-text
                                label="Nama Pembimbing KP" 
                                name="pembimbing_name" 
                                x-bind:value="selectedPembimbing ? selectedPembimbing.name : ''" 
                                x-on:click.prevent="$dispatch('open-modal', 'browsePembimbing')"
                                id="pembimbing_name"
                                :error="$errors->first('pembimbing_name')"
                                readonly="true"
                            />
                            {{-- end pilih pembimbing --}}
                            <!-- End input nomor pembimbing lapangan -->
                            <x-button type="submit" color="success" class="float-end">
                                Submit
                            </x-button>
                            </form>
                        </div>
                    </div>
                    {{-- end form metadata --}}
                </div>
                {{-- view surat izin --}}
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-3">
                    {{-- form metadata --}}
                    <div class="w-full mx-auto">
                        <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 h-full">
                            @if($suratIzin)
                                <p class="text-center dark:text-white">
                                    Surat Izin Instansi peserta
                                </p>
                                <iframe src="{{route('mahasiswa.kp.suratIzinView',['id' => $suratIzin->id])}}" width="100%" height="800px"></iframe>
                                <x-button type="submit" color="success" class="float-end mt-2"
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm')"
                                >
                                    Approve Judul KP
                                </x-button>
                            @else
                                <p class="text-center dark:text-white">
                                    Peserta belum mengumpulkan surat izin kp
                                </p>
                            @endif
                        </div>
                    </div>
                    {{-- end form metadata --}}
                </div>
            </div>
            {{-- end metadata --}}
            {{-- stepper --}}
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                    <ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400 mt-4 ms-4">
                        <li class="mb-10 ms-6 flex items-center">
                            <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                </svg>
                            </span>
                            <div class="">
                                <h3 class="font-medium leading-tight">Registrasi</h3>
                                <p class="text-sm">Mahasiswa berhasil registrasi akun</p>
                            </div>
                        </li>
                        <li class="mb-10 ms-6 flex items-center">
                            @if($kp->metadata)
                                @if(!isset($suratIzin))
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>                  
                                    </span>
                                    <div class="">
                                        <h3 class="font-medium leading-tight">Surat Izin</h3>
                                        <p class="text-sm">Mahasiswa belum menyerahkan surat izin kp dari instansi</p>
                                    </div>
                                @elseif($kp->metadata->status == 'awaited')
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-yellow-500 dark:text-yellow-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>                                      
                                    </span>
                                    <div class="">
                                        <h3 class="font-medium leading-tight">Surat Izin</h3>
                                        <p class="text-sm">Judul KP mahasiswa menunggu diulas</p>
                                    </div>
                                @elseif($kp->metadata->status == 'reviewed')
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-yellow-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-green-500 dark:text-yellow-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                    </span>
                                    <div class="">
                                        <h3 class="font-medium leading-tight">Surat Izin</h3>
                                        <p class="text-sm">Judul KP mahasiswa ditolak dan perlu diperbaiki</p>
                                    </div>
                                @elseif($kp->metadata->status == 'done')
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                        <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                        </svg>
                                    </span>
                                    <div class="">
                                        <h3 class="font-medium leading-tight">Surat Izin</h3>
                                        <p class="text-sm">Judul KP mahasiswa sudah disetujui</p>
                                    </div>
                                @endif
                            @elseif(!isset($kp->metadata))
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>                  
                                </span>
                                <div class="">
                                    <h3 class="font-medium leading-tight">Judul KP</h3>
                                    <p class="text-sm">Mahasiswa belum memenuhi data KP anda</p>
                                </div>
                            @endif
                        </li>
                        <li class="mb-10 ms-6 flex items-center">
                            @if($proposal)
                                @if($proposal->status == 'awaited')
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-yellow-500 dark:text-yellow-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>                                      
                                    </span>
                                    <div class="">
                                        <h3 class="font-medium leading-tight">Proposal</h3>
                                        <p class="text-sm">Proposal mahasiswa menunggu untuk diulas</p>
                                    </div>
                                @elseif($proposal->status == 'reviewed')
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-yellow-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-green-500 dark:text-yellow-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                    </span>
                                    <div class="">
                                        <h3 class="font-medium leading-tight">Proposal</h3>
                                        <p class="text-sm">Mahasiswa belum menyerahkan perbaikan proposal</p>
                                    </div>
                                @elseif($proposal->status == 'done')
                                    <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                        <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                        </svg>
                                    </span>
                                    <div class="">
                                        <h3 class="font-medium leading-tight">Proposal</h3>
                                        <p class="text-sm">Proposal mahasiswa sudah disetujui</p>
                                    </div>
                                @endif
                            @else
                            <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg> 
                            </span>
                            <div class="">
                                <h3 class="font-medium leading-tight">Proposal</h3>
                                <p class="text-sm">Mahasiswa belum menyerahkan file proposal anda</p>
                            </div>
                            @endif
                        </li>
                        <li class="mb-10 ms-6 flex items-center">
                            <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                </svg>
                            </span>
                            <div class="">
                                <h3 class="font-medium leading-tight">Pelaksanaan KP</h3>
                                <p class="text-sm">Mahasiswa sedang melaksanakan KP</p>
                            </div>
                        </li>
                        <li class="mb-10 ms-6 flex items-center">
                            <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg> 
                            </span>
                            <div class="">
                                <h3 class="font-medium leading-tight">Laporan</h3>
                                <p class="text-sm">Mahasiswa belum menyerahkan file Laporan anda</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- modal pilih pembimbing --}}
        <x-modal name="browsePembimbing" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <div class="p-6">
                <pre x-text="selectedPembimbing?.name"></pre>
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    <span>
                        Pilih pembimbing untuk KP
                    </span>
                </div>
                <x-table :data="$pembimbings" :filterFields="'[\'name\', \'nomor_induk\']'">
                    <x-slot name="newData">
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIDN</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Pembimbing</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Jumlah bimbingan</th>
                            <th scope="col" class="px-0 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Action</th>
                        </tr>
                    </x-slot>
                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="7" class="text-center py-4">No data available</td>
                        </tr>
                        <template x-for="(pembimbing, index) in paginatedData" :key="index">
                            <tr 
                                class="even:bg-white odd:bg-gray-100 hover:bg-gray-100 dark:even:bg-gray-800 dark:odd:bg-gray-700 dark:hover:bg-gray-700"
                                x-on:click.prevent="
                                    selectedPembimbing = pembimbing;
                                    $dispatch('close', 'browsePembimbing');
                                "
                            >
                                <td x-text="pembimbing.number" class="px-1 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.nomor_induk" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.name" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.kpCount" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-0 py-2 whitespace-nowrap text-center text-sm font-medium w-fit">
                                    <button 
                                        type="button" 
                                        class="py-1 px-2 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                        x-on:click.prevent="
                                            selectedPembimbing = pembimbing;
                                            $dispatch('close', 'browsePembimbing');
                                        "
                                    >
                                        Select
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                </div>
            </div>
        </x-modal>
        {{-- modal konfirmasi approve judul kp --}}
        <x-modal name="confirm" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Konfirmasi Setujui Judul KP?
                </div>
                <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <form @submit.prevent="submitApproveJudulKP">
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
            function submitForm(e) {
                Swal.fire({
                    title: 'Permintaan sedang diproses, mohon tunggu',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                const formData = new FormData(e.target);
                fetch("{{ route('kordinator.kp.assign',['id'=>$kp->id]) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData,
                })
                .then((data) => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Dosen pembimbing berhasil dipilih'
                    });
                })
                .catch(error => {
                    console.error('There was an error : ', error);
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Galat terjadi, silahkan hubungi pengembang atau cek di konsol'
                    });
                })
            }
            function submitApproveJudulKP(e) {
                Swal.fire({
                    title: 'Permintaan sedang diproses, mohon tunggu',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                const formData = new FormData(e.target);
                fetch("{{route('kordinator.kp.judul.approve',['id'=>$kp->id])}}",{
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData,
                })
                .then(response => {
                    if (response.redirected) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Proposal berhasil disetujui',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            window.location = "{{route('kordinator.kp.lists')}}";
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
                    }
                })
                .catch(error => {
                    console.error('There was an error : ', error);
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Galat terjadi, silahkan hubungi pengembang atau cek di konsol'
                    });
                })
            }
        </script>
    </div>
</x-app-layout>
