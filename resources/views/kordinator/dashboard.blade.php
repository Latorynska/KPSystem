<x-app-layout>
    <div class="py-5 flex items-center">
        {{-- card 1 --}}
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lg">
                            Judul menunggu diulas
                        </p>
                        <p class="text-xs text-gray-400">
                            Jumlah proposal kp yang diajukan mahasiswa dan menunggu untuk diulas
                        </p>
                    </div>
                    <div class="text-4xl items-center justify-center">
                        <p>{{$kp_awaited_count}}</p>
                    </div>
                </div>
            </div>
        </div>        
        {{-- end card 1 --}}
        {{-- card 2 --}}
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lg">
                            Proposal menunggu diulas
                        </p>
                        <p class="text-xs text-gray-400">
                            Jumlah proposal kp yang diajukan mahasiswa dan menunggu untuk diulas
                        </p>
                    </div>
                    <div class="text-4xl items-center justify-center">
                        <p>
                            {{$proposal_awaited_count}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- end card 2 --}}
        {{-- card 3 --}}
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lg">
                            Surat Bimbingan menunggu verifikasi
                        </p>
                        <p class="text-xs text-gray-400">
                            Jumlah mahasiswa menunggu verifikasi surat bimbingan
                        </p>
                    </div>
                    <div class="text-4xl flex items-center justify-center">
                        <p>
                            -
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- end card 3 --}}
    </div>
</x-app-layout>