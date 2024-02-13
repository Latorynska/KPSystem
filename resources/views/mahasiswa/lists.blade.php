<x-app-layout>
    <div class="py-5" x-data="{selectedMahasiswa : ''}">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <x-table :data="$mahasiswas" :filterFields="'[\'nomor_induk\',\'name\', \'email\']'" itemperpage="10">
                    <x-slot name="newData">
                        <x-button tag="a" color="" class="text-sm ml-4" x-data="{ syncing: false }" x-on:click.prevent="fetchData">
                            <span x-show="syncing">Menyinkronkan...</span>
                            <span x-show="!syncing">Sinkronkan Data</span>
                        </x-button>

                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIM</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Email</th>
                            <th scope="col" class="px-0 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400 w-fit">Action</th>
                        </tr>
                    </x-slot>

                    <x-slot name="body">
                        <tr x-show="paginatedData.length === 0">
                            <td colspan="7" class="text-center py-4 text-white">No data available</td>
                        </tr>
                        <template x-for="(mahasiswa, index) in paginatedData" :key="index">
                            <tr class="even:bg-gray-100 odd:bg-white hover:bg-gray-100 dark:even:bg-gray-700 dark:odd:bg-gray-800 dark:hover:bg-gray-700">
                                <td x-text="mahasiswa.number" class="px-1 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200"></td>
                                <td x-text="mahasiswa.nomor_induk" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="mahasiswa.name" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="mahasiswa.email" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-0 py-2 whitespace-nowrap text-center text-sm font-medium w-fit">
                                    <x-button type="button" color="warning" class="mt-2"
                                        x-on:click.prevent="$dispatch('open-modal', 'resetPassword'); selectedMahasiswa = mahasiswa;"
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
                    {{-- x-bind:action="{{ route('admin.mahasiswa.password.reset',['id' => "selectedMahasiswa.id"]) }}"  --}}
                    x-data="{ resetRoute: '{{ route('admin.mahasiswa.password.reset', ['id' => ':id']) }}' }"
                    x-bind:action="resetRoute.replace(':id', selectedMahasiswa.id)"
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
    </div>
    <script>
        function fetchData() {
            this.syncing = true; // Set syncing state to true
            Swal.fire({
                title: 'Permintaan sedang diproses, mohon tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                Swal.showLoading();
                }
            });
            // Your fetch logic goes here
            fetch('{{ route('admin.mahasiswa.sync') }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Respon jaringan bermasalah');
                    }
                    return response.json();
                })
                .then(data => {
                    window.location.reload();
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops',
                        html: 'Sebuah galat terjadi, silahkan cek konsol untuk informasi lebih lanjut',
                    })
                    console.error('Terdapat galat pada server, silahkan cek informasi lebih lanjut : ', error);
                })
                .finally(() => {
                    this.syncing = false;
                });
        }
        function submitResetPassword(e) {
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
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Password mahasiswa berhasil diatur ulang',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else if (response.status === 422) {
                    return response.json();
                } else {
                    throw new Error('Unexpected server response');
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
