<x-app-layout>
    <div class="py-5 flex items-center">
        {{-- file view --}}
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="text-center py-2">
                    {{"Proposal ".$proposal->kp->mahasiswa->name}}
                </div>
                {{-- <iframe src="http://127.0.0.1:8000/mahasiswa/kp/proposal/1" width="100%" height="800px"></iframe> --}}
                {{-- <iframe src="{{$fileUrl}}" width="100%" height="800px"></iframe> --}}
                {{-- <iframe src="data:application/pdf;base64,{{ base64_encode($fileUrl) }}" width="100%" height="800px"></iframe> --}}
                <iframe src="{{route('mahasiswa.kp.proposalView',['id' => $proposal->id])}}" width="100%" height="800px"></iframe>
            </div>
        </div>
        {{-- detail view --}}
        <div class="w-full mx-auto my-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                {{-- form metadata --}}
            <div class="w-full mx-auto">
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 h-full">
                    Form Perbaikan Proposal
                    <form action="{{ route('kordinator.kp.revisiProposal',['id' => $proposal->id]) }}" method="POST" @submit.prevent="submitForm">
                        @csrf
                        @method('POST')
                        <x-textarea
                            label="Latar Belakang" 
                            name="latar_belakang" 
                            id="latar_belakang"
                            value=""
                            :error="$errors->first('latar_belakang')"
                        />
                        <x-textarea
                            label="Identifikasi Masalah" 
                            name="identifikasi_masalah" 
                            id="identifikasi_masalah"
                            value=""
                            :error="$errors->first('identifikasi_masalah')"
                        />
                        <x-textarea
                            label="Rencana - Solusi" 
                            name="rencana_solusi" 
                            id="rencana_solusi"
                            value=""
                            :error="$errors->first('rencana_solusi')"
                        />
                        <x-textarea
                            label="Ruang Lingkup" 
                            name="ruang_lingkup" 
                            id="ruang_lingkup"
                            value=""
                            :error="$errors->first('ruang_lingkup')"
                        />
                        <x-textarea
                            label="Output KP" 
                            name="output_kp" 
                            id="output_kp"
                            value=""
                            :error="$errors->first('output_kp')"
                        />
                        <x-textarea
                            label="Metode KP" 
                            name="metode_kp" 
                            id="metode_kp"
                            value=""
                            :error="$errors->first('metode_kp')"
                        />
                        <x-textarea
                            label="Jadwal Pelaksanaan" 
                            name="jadwal_pelaksanaan" 
                            id="jadwal_pelaksanaan"
                            value=""
                            :error="$errors->first('jadwal_pelaksanaan')"
                        />
                        <x-textarea
                            label="Daftar Pustaka" 
                            name="daftar_pustaka" 
                            id="daftar_pustaka"
                            value=""
                            :error="$errors->first('daftar_pustaka')"
                        />
                        <x-button type="submit" color="success" class="float-end">
                            Submit
                        </x-button>
                    </form>
                </div>
            </div>
            {{-- end form metadata --}}
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
            fetch("{{ route('kordinator.kp.revisiProposal',['id' => $proposal->id]) }}", {
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