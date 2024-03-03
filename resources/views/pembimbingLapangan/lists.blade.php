<x-app-layout>
    <div class="py-5" x-data="{selectedUser:''}">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <x-table :data="$pembimbingLapangans" :filterFields="'[\'nomor_induk\',\'name\', \'email\']'">
                    <x-slot name="newData">
                        <div>
                            <x-button tag="button" color="default" 
                                x-on:click.prevent="$dispatch('open-modal', 'createData')"
                            >
                                Tambah Data Baru
                            </x-button>
                        </div>
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama</th>
                            <th scope="col" class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nomor Induk</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Email</th>
                            <th scope="col" class="px-0 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Action</th>
                        </tr>
                    </x-slot>

                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="7" class="text-center py-4 text-white">No data available</td>
                        </tr>
                        <template x-for="(pembimbing, index) in paginatedData" :key="index">
                            <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                <td x-text="pembimbing.number" class="px-1 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.name" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.nomor_induk" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.email" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-0 py-2 whitespace-nowrap text-center text-sm font-medium w-fit">
                                    <x-button type="button" color="success" class="mt-2"
                                    x-on:click.prevent="$dispatch('open-modal', 'resetPassword'); selectedUser = pembimbing;"
                                    >
                                        Reset Password
                                    </x-button>
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>
        {{-- modal konfirmasi reset password --}}
        <x-modal name="resetPassword" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Reset password akun mahasiswa?
                </div>
                <form 
                    method="POST" 
                    @submit.prevent="submitResetPassword"
                >
                    @csrf
                    @method('PATCH') 
                    <x-form-text
                        label="Masukkan Password Anda Sebagai Admin" 
                        name="admin_password" 
                        id="admin_password" 
                        type="password"
                        :error="$errors->first('admin_password')"
                    />
                    <div class="mt-6 flex justify-between">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                        <x-button type="submit" tag="button" color="success" x-on:click="$dispatch('close')">
                            Konfirmasi
                        </x-button>
                    </div>
                </form>
            </div>
        </x-modal>
        {{-- modal input data --}}
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
                    <!-- input nama pembimbing lapangan -->
                    <x-form-text
                        label="Nama Pembimbing Lapangan" 
                        name="name" 
                        {{-- :value="$kp->metadata ? $kp->metadata->instansi : ''"  --}}
                        id="name" 
                        :error="$errors->first('name')"
                    />
                    <!-- End input nama pembimbing lapangan -->
                    <!-- input nomor induk / username -->
                    <x-form-text
                        label="Username atau Nomor Handphone Pembimbing Lapangan" 
                        name="nomor_induk" 
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
