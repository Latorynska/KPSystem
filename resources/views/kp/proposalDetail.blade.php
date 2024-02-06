<x-app-layout>
    <div class="" x-data="{selectedPembimbing:''}">
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
                    <x-button type="submit" color="success" class="float-end mt-2"
                        x-on:click.prevent="$dispatch('open-modal', 'confirm')"
                    >
                        Approve Proposal
                    </x-button>
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
        {{-- modal konfirmasi --}}
        <x-modal name="confirm" focusable>
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    <span>
                        pilih pembimbing
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
                            <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Jumlah mahasiswa bimbingan</th>
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
                                "
                            >
                                <td x-text="pembimbing.number" class="px-1 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.nomor_induk" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.name" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.kpCount" class="px-1 py-4 text-center whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-0 py-2 whitespace-nowrap text-center text-sm font-medium w-fit">
                                    <button 
                                        type="button" 
                                        class="py-1 px-2 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                        x-on:click.prevent="
                                            selectedPembimbing = pembimbing;
                                        "
                                    >
                                        Select
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
                <p class="text-white">
                    Pembimbing Dipilih : <span x-text="selectedPembimbing?.name"></span>
                </p>
                @error('pembimbing_id')
                    <p class="text-red-500 text-xs mt-1 ms-1">Silahkan Pilih pembimbing terlebih dahulu</p>
                @enderror
                <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <form @submit.prevent="submitPembimbing">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="pembimbing_id" 
                            x-bind:value="selectedPembimbing ? selectedPembimbing.id : ''" 
                            value="{{ old('manager_id', $branch->manager->id ?? '')}}"
                        >
                        <x-button type="submit" tag="button" color="success" x-bind:disabled="!selectedPembimbing.id">
                            Pilih pembimbing dan setujui
                        </x-button>
                    </form>
                </div>
            </div>
        </x-modal>
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
        function submitPembimbing(e) {
            Swal.fire({
                title: 'Permintaan sedang diproses, mohon tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            const formData = new FormData(e.target);
            fetch("{{ route('kordinator.kp.assign',['id'=>$proposal->kp_id]) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData,
            })
            .then(response => {
                if (response.redirected) {
                    fetch("{{route('kordinator.kp.proposal.approve',['id'=>$proposal->id])}}",{
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
                                text: 'File Berhasil diunggah.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                window.location = "{{route('kordinator.kp.proposals')}}";
                            }, 1500);
                        } else {
                            return response.json();
                        }
                    });
                    
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
</x-app-layout>