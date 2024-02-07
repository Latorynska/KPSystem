<x-app-layout>
    <div class="py-5 flex items-center">
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
                            <p class="text-sm">Anda sukses registrasi akun</p>
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
                                <p class="text-sm">Anda sudah mengumpulkan surat izin</p>
                            </div>
                        @else
                            <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>                  
                            </span>
                            <div class="">
                                <h3 class="font-medium leading-tight">Surat Izin KP</h3>
                                <p class="text-sm">Anda belum menyerahkan file surat izin kp anda</p>
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
                                    <p class="text-sm">Proposal anda sedang diulas</p>
                                </div>
                            @elseif($proposal->status == 'reviewed')
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-green-500 dark:text-yellow-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                    </svg>
                                </span>
                                <div class="">
                                    <h3 class="font-medium leading-tight">Proposal</h3>
                                    <p class="text-sm">Proposal anda ditolak dan perlu diperbaiki</p>
                                </div>
                            @elseif($proposal->status == 'done')
                                <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                                    <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                                    </svg>
                                </span>
                                <div class="">
                                    <h3 class="font-medium leading-tight">Proposal</h3>
                                    <p class="text-sm">Proposal anda sudah disetujui</p>
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
                            <p class="text-sm">Anda belum menyerahkan file proposal anda</p>
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
                            <p class="text-sm">Jadwal Pelaksanaan KP</p>
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
                            <p class="text-sm">Anda belum menyerahkan file Laporan anda</p>
                        </div>
                    </li>
                    {{-- <li class="ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/>
                            </svg>
                        </span>
                        <h3 class="font-medium leading-tight">Confirmation</h3>
                        <p class="text-sm">Step details here</p>
                    </li> --}}
                </ol>
            </div>
        </div>
        {{-- KP data input section --}}
        <div class="w-full mx-auto my-auto sm:px-6 lg:px-8">
            {{-- form metadata --}}
            <div class="w-full mx-auto">
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 h-full">
                    Form Data KP
                    <form action="{{ route('mahasiswa.kp.metadata') }}" method="POST" @submit.prevent="submitForm">
                        @csrf
                        @method('PATCH')
                        <!-- input Judul KP -->
                        <x-form-text
                            label="Judul KP" 
                            name="judul" 
                            :value="$kp->metadata ? $kp->metadata->judul : ''" 
                            id="judul" 
                            :error="$errors->first('judul')"
                        />
                        <!-- End input judul kp-->
                        <!-- input nama instansi -->
                        <x-form-text
                            label="Nama Instansi" 
                            name="instansi" 
                            :value="$kp->metadata ? $kp->metadata->instansi : ''" 
                            id="instansi" 
                            :error="$errors->first('instansi')"
                        />
                        <!-- End input nama instansi -->
                        <!-- input nama pembimbing lapangan -->
                        <x-form-text
                            label="Nama Pembimbing Lapangan" 
                            name="nama_pembimbing_lapangan" 
                            :value="$kp->metadata ? $kp->metadata->nama_pembimbing_lapangan : ''" 
                            id="nama_pembimbing_lapangan"
                            :error="$errors->first('nama_pembimbing_lapangan')"
                        />
                        <!-- End input nama pembimbing lapangan -->
                        <!-- input nomor pembimbing lapangan -->
                        <x-form-text
                            label="Nomor Telepon Pembimbing Lapangan" 
                            name="nomor_pembimbing_lapangan" 
                            :value="$kp->metadata ? $kp->metadata->nomor_pembimbing_lapangan : ''" 
                            id="nomor_pembimbing_lapangan"
                            :error="$errors->first('nomor_pembimbing_lapangan')"
                        />
                        
                        <!-- End input nomor pembimbing lapangan -->
                        <x-button type="submit" color="success" class="float-end">
                            Submit
                        </x-button>
                    </form>
                </div>
            </div>
            {{-- end form metadata --}}
            {{-- input surat izin card --}}
            <div x-data="{ suratIzinFile: '{{ $suratIzinFile ?? '' }}' }" @dragover.prevent @dragenter.prevent @drop.prevent="suratIzinFile = $event.dataTransfer.files[0].name">
                <form action="{{ route('mahasiswa.kp.suratIzinPost') }}" method="POST" enctype="multipart/form-data" @submit.prevent="uploadFile($event)">
                    @csrf
                    @method('POST')
                    <div class="bg-white my-3 dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                        <p class="text-white pb-2">Surat Izin</p>
                        <div class="flex items-center justify-center w-full" x-show="!suratIzinFile">
                            <label for="suratIzinFile" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF (Max 1MB)</p>
                                </div>
                                <input id="suratIzinFile" name="surat_izin" type="file" class="hidden" accept=".pdf" @change="suratIzinFile = $event.target.files[0].name" />
                            </label>
                        </div>
                        <!-- Display file name -->
                        <div class="flex items-center" x-show="suratIzinFile">
                            <x-button tag="a" href="{{ $suratIzin ? route('mahasiswa.kp.suratIzinView',['id' => $suratIzin->id]) : '#' }}" target="_blank">
                                <span x-text="suratIzinFile"></span>
                            </x-button>
                            <div class="relative group ml-2">
                                <!-- Tooltip -->
                                <span class="absolute left-10 top-0 transform -translate-y-1/2 mt-1 hidden group-hover:block bg-gray-900 text-white text-xs font-medium px-2 py-1 rounded shadow-sm dark:bg-slate-700 w-32" role="tooltip">
                                    click the file name button to view the file
                                </span>
                                <!-- Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                            </div>
                        </div>
                        {{-- end display file name --}}
                        <div class="flex justify-between mt-2" x-show="suratIzinFile">
                            <x-button tag="button" color="danger" type="button" @click.prevent="suratIzinFile = ''">
                                {{ isset($suratIzinFile) ? 'replace' : 'Cancel'}}
                            </x-button>
                            <x-button tag="button" type="submit" color="success" x-show="suratIzinFile && suratIzinFile !== '{{ $suratIzinFile ?? '' }}'">
                                {{ isset($suratIzinFile) ? 'ReUpload' : 'Upload'}}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- end input surat izin --}}
            @if($suratIzin && $suratIzinFile)
            {{-- input proposal card --}}
            <div x-data="{ proposalFile: '{{ $proposalFile ?? '' }}' }" @dragover.prevent @dragenter.prevent @drop.prevent="proposalFile = $event.dataTransfer.files[0].name">
                <form action="{{ route('mahasiswa.kp.proposalPost') }}" method="POST" enctype="multipart/form-data" @submit.prevent="uploadFile($event)">
                    @csrf
                    @method('POST')
                    <div class="bg-white my-3 dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                        <p class="text-white pb-2">Proposal</p>
                        <div class="flex items-center justify-center w-full" x-show="!proposalFile">
                            <label for="proposalFile" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF (Max 1MB)</p>
                                </div>
                                <input id="proposalFile" name="proposal" type="file" class="hidden" accept=".pdf" @change="proposalFile = $event.target.files[0].name" />
                            </label>
                        </div><!-- Display file name -->
                        <div class="flex items-center" x-show="proposalFile">
                            <x-button tag="a" href="{{ $proposal ? route('mahasiswa.kp.proposalView',['id' => $proposal->id]) : '#' }}" target="_blank">
                                <span x-text="proposalFile"></span>
                            </x-button>
                            <div class="relative group ml-2">
                                <!-- Tooltip -->
                                <span class="absolute left-10 top-0 transform -translate-y-1/2 mt-1 hidden group-hover:block bg-gray-900 text-white text-xs font-medium px-2 py-1 rounded shadow-sm dark:bg-slate-700 w-32" role="tooltip">
                                    click the file name button to view the file
                                </span>
                                <!-- Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                            </div>
                        </div>
                        {{-- end display file name --}}
                        <div class="flex justify-between mt-2" x-show="proposalFile">
                            <x-button tag="button" color="danger" type="button" @click.prevent="proposalFile = ''" x-show="proposalFile != '{{$proposal ? $proposal->file_name : ''}}' || '{{ $proposal ? $proposal->status : '' }}' == 'reviewed'">
                                {{ isset($proposalFile) ? 'replace' : 'Cancel'}}
                            </x-button>
                            @if($proposal?->revisi && $proposal->status == 'reviewed')
                            <x-button tag="button" type="button" color="warning"
                                x-on:click.prevent="$dispatch('open-modal', 'reviewDetail')"
                            >
                                Lihat Pesan Revisi
                            </x-button>
                            @endif
                            @if($proposal?->status == 'done')
                                <x-button tag="a" :href="route('mahasiswa.kp.proposal.lembarPengesahan',['id'=>Auth()->id()])" target="_blank" color="success">
                                    Download Lembar Pengesahan
                                </x-button>
                            @endif
                            <x-button tag="button" type="submit" color="success" x-show="proposalFile && proposalFile !== '{{ $proposalFile ?? '' }}'">
                                {{ isset($proposalFile) ? 'ReUpload' : 'Upload'}}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- end input proposal --}}
            @endif
            @if($proposal && $proposal->status =="done")
            {{-- input laporan card --}}
            <div x-data="{ laporanFile: '{{ $laporanFile ?? '' }}' }" @dragover.prevent @dragenter.prevent @drop.prevent="laporanFile = $event.dataTransfer.files[0].name">
                <form action="{{ route('mahasiswa.kp.laporanPost') }}" method="POST" enctype="multipart/form-data" @submit.prevent="uploadFile($event)">
                    @csrf
                    @method('POST')
                    <div class="bg-white my-3 dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                        <p class="text-white pb-2">Laporan KP</p>
                        <div class="flex items-center justify-center w-full" x-show="!laporanFile">
                            <label for="laporanFile" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF (Max 1MB)</p>
                                </div>
                                <input id="laporanFile" name="laporan" type="file" class="hidden" accept=".pdf" @change="laporanFile = $event.target.files[0].name" />
                            </label>
                        </div>
                        <!-- Display file name -->
                        <div class="flex items-center" x-show="laporanFile">
                            <x-button tag="a" href="{{ $laporan ? route('mahasiswa.kp.laporanView',['id' => $laporan->id]) : '#' }}" target="_blank">
                                <span x-text="laporanFile"></span>
                            </x-button>
                            <div class="relative group ml-2">
                                <!-- Tooltip -->
                                <span class="absolute left-10 top-0 transform -translate-y-1/2 mt-1 hidden group-hover:block bg-gray-900 text-white text-xs font-medium px-2 py-1 rounded shadow-sm dark:bg-slate-700 w-32" role="tooltip">
                                    click the file name button to view the file
                                </span>
                                <!-- Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                            </div>
                        </div>
                        {{-- end display file name --}}
                        <div class="flex justify-between mt-2" x-show="laporanFile">
                            <x-button tag="button" color="danger" type="button" @click.prevent="laporanFile = ''">
                                {{ isset($laporanFile) ? 'replace' : 'Cancel'}}
                            </x-button>
                            <x-button tag="button" type="submit" color="success">
                                {{ isset($laporanFile) ? 'ReUpload' : 'Upload'}}
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- end laporan --}}
            @endif
        </div>
    </div>
    {{-- modal pesan revisi --}}
    <x-modal name="reviewDetail" focusable>
        <div class="p-6">
            <div class="flex items-center justify-between p-2 text-lg font-bold dark:text-white">
                <span>
                    Pesan dari kordinator untuk perbaikan proposal 
                </span>
            </div>
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                  <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Bagian</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="px-5">
                    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">Latar belakang</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$proposal?->revisi?->latar_belakang ? $proposal?->revisi?->latar_belakang : 'Tidak ada revisi'}}</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">Identifikasi masalah</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$proposal?->revisi?->identifikasi_masalah ? $proposal?->revisi?->identifikasi_masalah : 'Tidak ada revisi'}}</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">Rencana - Solusi</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$proposal?->revisi?->rencana_solusi ? $proposal?->revisi?->rencana_solusi : 'Tidak ada revisi'}}</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">Ruang lingkup</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$proposal?->revisi?->ruang_lingkup ? $proposal?->revisi?->ruang_lingkup : 'Tidak ada revisi'}}</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">Output KP</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$proposal?->revisi?->output_kp ? $proposal?->revisi?->output_kp : 'Tidak ada revisi'}}</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">Metode KP</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$proposal?->revisi?->metode_kp ? $proposal?->revisi?->metode_kp : 'Tidak ada revisi'}}</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">Jadwal pelaksanaan</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$proposal?->revisi?->jadwal_pelaksanaan ? $proposal?->revisi?->jadwal_pelaksanaan : 'Tidak ada revisi'}}</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-900 dark:even:bg-slate-800">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">Daftar pustaka</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$proposal?->revisi?->daftar_pustaka ? $proposal?->revisi?->daftar_pustaka : 'Tidak ada revisi'}}</td>
                    </tr>
                </tbody>
            </table>            
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Close
                </x-secondary-button>
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
            fetch('{{ route("mahasiswa.kp.metadata") }}', {
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
        function uploadFile(e) {
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
                        text: 'File Berhasil diunggah.',
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
