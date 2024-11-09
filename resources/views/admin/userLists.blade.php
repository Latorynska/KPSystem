<x-app-layout>
    <div class="py-5" x-data="{selectedMahasiswa : ''}">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <div class="text-center dark:text-white text-black text-2xl">
                    <p>Mahasiswa List</p>
                </div>
                <x-table :data="$mahasiswas" :filterFields="'[\'nomor_induk\',\'name\', \'email\']'" itemperpage="10">
                    <x-slot name="newData">
                        <div>
                            <x-button tag="button" color="default" 
                                x-on:click.prevent="$dispatch('open-modal', 'uploadData')"
                            >
                                Import from excel
                            </x-button>
                            {{-- <x-button tag="a" color="" class="text-sm ml-4" x-data="{ syncing: false }" x-on:click.prevent="fetchData">
                                <span x-show="syncing == true">Menyinkronkan...</span>
                                <span x-show="syncing == false">Sinkronkan Data</span>
                            </x-button> --}}
                        </div>
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
                    x-data="{ resetRoute: '{{ route('admin.user.password.reset', ['id' => ':id']) }}' }"
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
        {{-- modal upload excel --}}
        <x-modal name="uploadData" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Pilih file data mahasiswa dengan data NIM, Nama, Email
                </div>
                {{-- input data file --}}
                <div x-data="{dataFile:''}" @dragover.prevent @dragenter.prevent @drop.prevent="dataFile = $event.dataTransfer.files[0].name">
                    <form 
                        action={{route('admin.mahasiswa.import')}}
                        method="POST" 
                        @submit.prevent="postImportMahasiswa"
                    >
                        @csrf
                        @method('POST') 
                        <div class="bg-white my-3 dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                            <p class="text-white pb-2">Data Mahasiswa</p>
                            <div class="flex items-center justify-center w-full" x-show="!dataFile">
                                <label for="dataFile" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Excel File</p>
                                    </div>
                                    <input id="dataFile" name="data_file" type="file" class="hidden" accept=".xlsx" @change="dataFile = $event.target.files[0].name" />
                                </label>
                            </div>
                            <!-- Display file name -->
                            <div class="flex items-center" x-show="dataFile">
                                <x-button tag="button" target="_blank">
                                    <span x-text="dataFile"></span>
                                </x-button>
                                <div class="relative group ml-2">
                                    <span class="absolute left-10 top-0 transform -translate-y-1/2 mt-1 hidden group-hover:block bg-gray-900 text-white text-xs font-medium px-2 py-1 rounded shadow-sm dark:bg-slate-700 w-32" role="tooltip">
                                        Pastikan format file isinya sudah sesuai sebelum anda submit
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                    </svg>
                                </div>
                            </div>
                            {{-- end display file name --}}
                        </div>
                        <div class="mt-6 flex justify-between">
                            <x-secondary-button x-on:click="$dispatch('close');dataFile=''">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-button type="submit" tag="button" color="success" x-on:click="$dispatch('close')" x-show="dataFile">
                                Konfirmasi
                            </x-button>
                        </div>
                    </form>
                </div>
                {{-- end input data file --}}
            </div>
        </x-modal>
    </div>
    <div class="py-5" x-data="{selectedPembimbing:''}">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                <x-table :data="$pembimbings" :filterFields="'[\'nomor_induk\',\'name\', \'email\']'">
                    <x-slot name="newData">
                        <div>
                            <x-button tag="button" color="default" 
                                x-on:click.prevent="$dispatch('open-modal', 'uploadData')"
                            >
                                Import from excel
                            </x-button>
                            {{-- <x-button tag="a" color="" class="text-sm ml-4" x-data="{ syncing: false }" x-on:click.prevent="fetchData">
                                <span x-show="syncing">Menyinkronkan...</span>
                                <span x-show="!syncing">Sinkronkan Data</span>
                            </x-button> --}}
                        </div>
                    </x-slot>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-1 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="px-1 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">NIDN</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nama</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Email</th>
                            <th scope="col" class="px-0 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Jumlah Mahasiswa Bimbingan</th>
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
                                <td x-text="pembimbing.nomor_induk" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.name" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.email" class="px-1 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td x-text="pembimbing.kpCount" class="px-0 py-4 text-center whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"></td>
                                <td class="px-0 py-2 whitespace-nowrap text-center text-sm font-medium w-fit">
                                    <x-button type="button" color="success" class="mt-2"
                                        x-on:click.prevent="$dispatch('open-modal', 'linkGrupModal'); selectedPembimbing= pembimbing;"
                                    >
                                        Ubah Link Grup
                                    </x-button>
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-table>
            </div>
        </div>
        {{-- modal ganti link grup bimbingan --}}
        <x-modal name="linkGrupModal" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Link Grup Bimbingan
                </div>
                <form 
                    x-data="{ postRoute: '{{ route('admin.dosen.grup.link.post', ['id' => ':id']) }}' }"
                    x-bind:action="postRoute.replace(':id', selectedPembimbing.id)"
                    method="POST" 
                    @submit.prevent="submitLinkGrup"
                >
                    @csrf
                    @method('POST') 
                    <x-form-text
                        label="Masukkan link grup sosial media mahasiswa bimbingan untuk bergabung"
                        name="link_grup" 
                        id="link_grup"
                        x-bind:value="selectedPembimbing.grup_bimbingan && selectedPembimbing.grup_bimbingan.link_grup ? selectedPembimbing.grup_bimbingan.link_grup : ''"
                        :error="$errors->first('link_grup')"
                        {{-- required --}}
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
        {{-- modal upload excel --}}
        <x-modal name="uploadData" focusable maxWidth="xl">
            <div class="p-6">
                <div class="flex items-center justify-between p-2 text-lg font-bold text-white">
                    Pilih file data dosen pembimbing dengan data NIDN, Nama, Email
                </div>
                {{-- input data file --}}
                <div x-data="{dataFile:''}" @dragover.prevent @dragenter.prevent @drop.prevent="dataFile = $event.dataTransfer.files[0].name">
                    <form 
                        action={{route('admin.dosen.import')}}
                        method="POST" 
                        @submit.prevent="postImportDosen"
                    >
                        @csrf
                        @method('POST') 
                        <div class="bg-white my-3 dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4">
                            <p class="text-white pb-2">Data Dosen Pembimbing</p>
                            <div class="flex items-center justify-center w-full" x-show="!dataFile">
                                <label for="dataFile" class="flex flex-col items-center justify-center w-full h-28 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Excel File</p>
                                    </div>
                                    <input id="dataFile" name="data_file" type="file" class="hidden" accept=".xlsx" @change="dataFile = $event.target.files[0].name" />
                                </label>
                            </div>
                            <!-- Display file name -->
                            <div class="flex items-center" x-show="dataFile">
                                <x-button tag="button" target="_blank">
                                    <span x-text="dataFile"></span>
                                </x-button>
                                <div class="relative group ml-2">
                                    <span class="absolute left-10 top-0 transform -translate-y-1/2 mt-1 hidden group-hover:block bg-gray-900 text-white text-xs font-medium px-2 py-1 rounded shadow-sm dark:bg-slate-700 w-32" role="tooltip">
                                        Pastikan format file isinya sudah sesuai sebelum anda submit
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                    </svg>
                                </div>
                            </div>
                            {{-- end display file name --}}
                        </div>
                        <div class="mt-6 flex justify-between">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-button type="submit" tag="button" color="success" x-on:click="$dispatch('close')" x-show="dataFile">
                                Konfirmasi
                            </x-button>
                        </div>
                    </form>
                </div>
                {{-- end input data file --}}
            </div>
        </x-modal>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        function fetchData() {
            this.syncing = true;
            Swal.fire({
                title: 'Permintaan sedang diproses, mohon tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('{{ route('admin.mahasiswa.sync') }}')
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw data;
                        });
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
                        html: '<p>Sebuah galat terjadi, dengan pesan : </p><p>' + error.message + '</p>',
                    });
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
                        text: 'Password berhasil diatur ulang',
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
        // function postImportMahasiswa(e) {
        //     Swal.fire({
        //         title: 'Permintaan sedang diproses, mohon tunggu',
        //         allowOutsideClick: false,
        //         showConfirmButton: false,
        //         didOpen: () => {
        //             Swal.showLoading();
        //         }
        //     });

        //     let form = e.target;
        //     let formData = new FormData(form);

        //     fetch(form.action, {
        //         method: 'POST',
        //         body: formData
        //     })
        //     .then(response => {
        //         if (response.ok) {
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Success!',
        //                 text: 'Data Mahasiswa Berhasil Ditambahkan',
        //                 timer: 1500,
        //                 showConfirmButton: false
        //             });
        //             setTimeout(() => {
        //                 window.location.reload();
        //             }, 1500);
        //         } else if (response.status === 422) {
        //             return response.json();
        //         } else {
        //             throw new Error('Unexpected server response');
        //         }
        //     })
        //     .then(data => {
        //         if (data && data.hasOwnProperty('errors')) {
        //             let errorMessages = Object.values(data.errors).join('\n');
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Validation Error',
        //                 text: errorMessages
        //             });
        //         }
        //     })
        //     .catch(error => {
        //         Swal.close();
        //         console.error(error);
        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Oops...',
        //             text: 'An error occurred!',
        //         });
        //     });
        // }
        function postImportMahasiswa(e) {
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
            let fileInput = form.querySelector('input[type="file"]');
            
            let file = fileInput.files[0];
            let reader = new FileReader();

            reader.onload = function (e) {
                let data = new Uint8Array(e.target.result);
                let workbook = XLSX.read(data, { type: 'array' });
                let sheetName = workbook.SheetNames[0];
                let worksheet = workbook.Sheets[sheetName];
                let jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
                let headerRow = jsonData.shift();
                let formattedData = jsonData.map(row => {
                    let obj = {};
                    headerRow.forEach((header, index) => {
                        if (header.toLowerCase() === 'nim' || header.toLowerCase() === 'nama' || header.toLowerCase() === 'email') {
                            obj[header] = row[index];
                        }
                    });
                    return obj;
                });

                const csrfToken = '{{ csrf_token() }}';

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ data: formattedData }),
                })
                .then(response => {
                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data Mahasiswa Berhasil Ditambahkan',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
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
            };

            reader.readAsArrayBuffer(file);
        }
    </script>
</x-app-layout>
