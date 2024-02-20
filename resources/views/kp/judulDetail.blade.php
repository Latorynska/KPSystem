<x-app-layout>
    <div class="" x-data="">
        <div class="py-5 flex items-center">
            {{-- surat izin --}}
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                {{-- view surat izin --}}
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-3">
                    <div class="w-full mx-auto">
                        <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 h-full">
                            @if($suratIzin)
                                <p class="text-center dark:text-white">
                                    Surat Izin Instansi peserta
                                </p>
                                <iframe src="{{route('mahasiswa.kp.suratIzinView',['id' => $suratIzin->id])}}" width="100%" height="800px"></iframe>
                                <div class="flex justify-between">
                                    <x-button tag="a" class="float-end mt-2"
                                        href="{{ $suratIzin ? route('mahasiswa.kp.suratIzinView',['id' => $suratIzin->id]) : '#' }}" target="_blank"
                                    >
                                        Lihat di tab baru
                                    </x-button>
                                    <div>
                                        <x-button type="submit" color="danger" class="mt-2"
                                            x-on:click.prevent="$dispatch('open-modal', 'rejectSuratIzin')"
                                        >
                                            Tolak Judul KP
                                        </x-button>
                                        <x-button type="submit" color="success" class="mt-2"
                                            x-on:click.prevent="$dispatch('open-modal', 'confirmSuratIzin')"
                                        >
                                            Setujui Surat Izin
                                        </x-button>
                                    </div>
                                </div>
                            @else
                                <p class="text-center dark:text-white">
                                    Peserta belum mengumpulkan surat izin kp
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- end surat izin --}}
            </div>
            {{-- metadata --}}
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                    {{-- form metadata --}}
                    <div class="w-full mx-auto">
                        <form action="{{ route('kordinator.kp.judul.approve',['id' => $kp->id]) }}" method="PATCH" @submit.prevent="submitRequest">
                            @csrf
                            @method('PATCH')
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
                                @if($kp->metadata?->status != 'done')
                                <div class="flex justify-between">
                                    <x-button type="submit" color="danger" class="mt-2"
                                        x-on:click.prevent="$dispatch('open-modal', 'rejectJudul')"
                                    >
                                        Tolak Judul KP
                                    </x-button>
                                    <x-button type="submit" color="success" class="mt-2"
                                        x-on:click.prevent="$dispatch('open-modal', 'confirmJudul')"
                                    >
                                        Setujui Judul KP
                                    </x-button>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    {{-- end form metadata --}}
                </div>
            </div>
            {{-- end metadata --}}
        </div>
        {{-- modal konfirmasi approve judul kp --}}
        <x-modal name="confirmJudul" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Konfirmasi Setujui Judul KP?
                </div>
                <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <form action={{route('kordinator.kp.judul.approve',['id'=>$kp->id])}} @submit.prevent="submitRequest" >
                        @csrf
                        @method('PATCH')
                        <x-button type="submit" tag="button" color="success">
                            Konfirmasi
                        </x-button>
                    </form>
                </div>
            </div>
        </x-modal>
        {{-- modal konfirmasi approve surat izin --}}
        @if($suratIzin)
        <x-modal name="confirmSuratIzin" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Konfirmasi Setujui Judul KP?
                </div>
                <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <form @submit.prevent="submitRequest" action={{route('kordinator.kp.suratIzin.approve',['id'=>$suratIzin->id])}}>
                        @csrf
                        @method('PATCH')
                        <x-button type="submit" tag="button" color="success">
                            Konfirmasi
                        </x-button>
                    </form>
                </div>
            </div>
        </x-modal>
        @endif
        {{-- modal tolak judul kp --}}
        <x-modal name="rejectJudul" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Yakin ingin menolak judul KP?
                </div>
                
                <form @submit.prevent="submitTolakJudul" action={{route('kordinator.kp.judul.revisi',['id'=>$kp->id])}} method="POST">
                <x-textarea
                    label="Pesan Penolakan Judul KP" 
                    name="pesan_revisi" 
                    id="pesan_revisi"
                    :value="$kp->metadata?->pesan_revisi ? $kp->metadata->pesan_revisi : ''" 
                    :error="$errors->first('pesan_revisi')"
                />
                <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    @csrf
                    @method('PATCH')
                    <x-button type="submit" tag="button" color="success">
                        Konfirmasi
                    </x-button>
                </div>
                </form>
            </div>
        </x-modal>
        {{-- modal tolak surat izin kp --}}
        <x-modal name="rejectSuratIzin" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Yakin ingin menolak judul KP?
                </div>
                <form @submit.prevent="submitRequest" action={{route('kordinator.kp.suratIzin.revisi',['id'=>$kp->id])}} method="POST">
                <x-textarea
                    label="Pesan Penolakan Surat Izin KP" 
                    name="pesan_revisi" 
                    id="pesan_revisi"
                    :value="$kp->surat_izin?->pesan_revisi ? $kp->surat_izin->pesan_revisi : ''" 
                    :error="$errors->first('pesan_revisi')"
                />
                <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    @csrf
                    @method('PATCH')
                    <x-button type="submit" tag="button" color="success">
                        Konfirmasi
                    </x-button>
                </div>
                </form>
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
            function submitApproveSuratIzin(e) {
                Swal.fire({
                    title: 'Permintaan sedang diproses, mohon tunggu',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData(e.target);
                @if ($suratIzin)
                fetch("{{ route('kordinator.kp.suratIzin.approve', ['id' => $suratIzin->id]) }}", {
                    method: 'PATCH',
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
                            text: 'Judul KP berhasil disetujui',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            window.location = "{{ route('kordinator.kp.juduls') }}";
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
                @else
                Swal.fire({
                    icon: 'error',
                    title: 'Surat Izin Error',
                    text: 'Surat Izin tidak tersedia.'
                });
                @endif
            }
            function submitTolakJudul(e) {
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
                            text: 'Judul Kp telah ditolak.',
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
            function submitRequest(e) {
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
                            text: 'Permintaan berhasil disimpan',
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
                    } else if(data && data.hasOwnProperty('message')){
                        let messages = Object.values(message);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Got Message From Server',
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
    </div>
</x-app-layout>
