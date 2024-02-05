<x-app-layout>
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
                        <div class="relative mb-3">
                            <select data-hs-select='{
                                    "placeholder": "Pembimbing KP",
                                    "toggleTag": "<button type=\"button\"></button>",
                                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
                                    "dropdownClasses": "mt-2 z-50 w-full max-h-[400px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                                }'
                                name="pembimbing_id"
                            >
                                <option value="">choose</option>
                                @foreach ($pembimbings as $pembimbing)  
                                    <option value="{{ $pembimbing->id }}" {{ (old('pembimbing_id') == $pembimbing->id || $kp->pembimbing_id == $pembimbing->id) ? 'selected' : '' }}>
                                        {{ $pembimbing->nomor_induk.' - '.$pembimbing->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute top-1/2 end-2.5 -translate-y-1/2">
                                <svg class="flex-shrink-0 w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                            </div>
                        </div>
                        @error('pembimbing_id')
                            <p class="text-red-500 text-xs mt-1 ms-1">{{ $message }}</p>
                        @enderror
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
                    {{-- <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Surat Izin KP</h3>
                        <p class="text-sm">Anda belum menyerahkan file surat izin kp anda</p>
                    </li> --}}
                    <li class="mb-10 ms-6 flex items-center">
                        @if($suratIzin)
                            <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                </svg>
                            </span>
                            <div class="">
                                <h3 class="font-medium leading-tight">Surat Izin KP</h3>
                                <p class="text-sm">Mahasiswa sudah mengumpulkan surat izin</p>
                            </div>
                        @else
                            <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>                  
                            </span>
                            <div class="">
                                <h3 class="font-medium leading-tight">Surat Izin KP</h3>
                                <p class="text-sm">Mahasiswa belum menyerahkan file surat izin kp</p>
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
            .catch(error => {
                console.error('There was an error : ', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Galat terjadi, silahkan hubungi pengembang atau cek di konsol'
                });
            })
            .finally(() => {
                Swal.close();
            });
        }
    </script>
</x-app-layout>
