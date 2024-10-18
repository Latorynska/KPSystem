<x-app-layout>
    <div class="py-5" x-data="{ selectedKp: {}}">
        {{auth()->user()->role}}
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="overflow-x-scroll">
                    <x-table :data="$kps" :filterFields="'[\'mahasiswa.nomor_induk\',\'mahasiswa.name\', \'kp.metadata.judul\']'">
                        <x-slot name="newData"></x-slot>
                        <x-slot name="header">
                            <tr>
                                <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIM mahasiswa</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Mahasiswa</th>
                                <th scope="col" class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Judul KP</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Penguji</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Pembimbing</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama Pembimbing Lapangan</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nilai Penguji</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nilai Pembimbing</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nilai Pembimbing Lapangan</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nilai Kordinator</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Tanggal Seminar</th>
                            </tr>
                        </x-slot>
    
                        <x-slot name="body">
                            <tr x-show="paginatedData.length === 0">
                                <td colspan="7" class="text-center py-4 text-white">No data available</td>
                            </tr>
                            <template x-for="(kp, index) in paginatedData" :key="index">
                                <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                    <td x-text="kp.number" class="px-2 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                    <td x-text="kp.mahasiswa.nomor_induk" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td x-text="kp.mahasiswa.name" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td x-text="kp.metadata ? kp.metadata.judul : 'belum diisi'" class="px-1 py-4 text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td x-text="kp.penilaian.penguji.name" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td x-text="kp.pembimbing.name" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td x-text="kp.metadata.nama_pembimbing_lapangan" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td x-text="kp.penilaian.nilaiPenguji ? 'nilai penguji' : 'no data'" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td x-text="kp.penilaian.nilaiPembimbing ? 'nilai pembimbing' : 'no data'" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                    <td x-show="kp.penilaian && kp.penilaian.pembimbing_lapangan_id"  x-text="kp.penilaian.nilaiLapangan ? 'nilai Lapangan' : 'no data'" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">

                                    </td>
                                    <td  x-show="!(kp.penilaian && kp.penilaian.pembimbing_lapangan_id)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        <x-button tag="button" color="success" 
                                            x-on:click.prevent="$dispatch('open-modal', 'createData'); selectedKp=kp;"
                                        >
                                            Tambah Pembimbing
                                        </x-button>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                        <p x-text="kp.penilaian.nilaiKordinator ? 'nilai kordinator' : 'no data'"></p>
                                        @hasrole('kordinator')
                                        <x-button tag="button" color="success" 
                                            x-on:click.prevent=""
                                        >
                                            Isi Nilai
                                        </x-button>
                                        @endhasrole
                                    </td>
                                    <td x-text="kp.syarat_seminar.tanggal" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-table>
                </div>
            </div>
        </div>
        {{-- modal input data pembimbing lapangan --}}
        <x-modal name="createData" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Masukkan Data Pembimbing Lapangan Baru
                </div>
                {{-- input data pembimbing lapangan --}}
                <form 
                    action={{route('admin.pembimbingLapangan.create')}}
                    method="POST" 
                    @submit.prevent="submitForm"
                >
                    @csrf
                    @method('POST') 
                    <input type="hidden" x-bind:value="selectedKp.id" name="kp_id">
                    <!-- input nama pembimbing lapangan -->
                    <x-form-text
                        label="Nama Pembimbing Lapangan" 
                        name="name" 
                        x-bind:value="selectedKp.metadata ? selectedKp.metadata.nama_pembimbing_lapangan : ''" 
                        id="name" 
                        :error="$errors->first('name')"
                    />
                    <!-- End input nama pembimbing lapangan -->
                    <!-- input nomor induk / username -->
                    <x-form-text
                        label="Username atau Nomor Handphone Pembimbing Lapangan" 
                        name="nomor_induk" 
                        x-bind:value="selectedKp.metadata ? selectedKp.metadata.nomor_pembimbing_lapangan : ''" 
                        id="nomor_induk" 
                        :error="$errors->first('nomor_induk')"
                    />
                    <!-- End input nomor induk / username -->
                    <!-- input nomor induk / username -->
                    <x-form-text
                        label="Email Pembimbing Lapangan" 
                        name="email" 
                        id="email" 
                        :error="$errors->first('email')"
                        type="email"
                    />
                    <!-- End input nomor induk / username -->
                    <p class="text-xs text-gray-400">
                        *Catatan : Password akan dibuat secara default, untuk username diwajibkan agar menggunakan data unik seperti nomor handphone atau nomor induk
                    </p>
                    <div class="mt-6 flex justify-between">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-button type="submit" tag="button" color="success" x-on:click="$dispatch('close')">
                            Submit
                        </x-button>
                    </div>
                </form>
                {{-- end input data pembimbing lapangan --}}
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
                        text: 'Akun pembimbing berhasil dibuat',
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
                } else if(data){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Got Message From Server',
                        text: data.message
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