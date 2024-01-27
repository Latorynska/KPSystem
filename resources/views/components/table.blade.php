<div x-data="initPagination({!! htmlspecialchars(json_encode($data)) !!}, {!! htmlspecialchars($filterFields) !!})" {{ $attributes }}>
    <div class="py-3 px-4 flex items-center justify-between">
        <!-- Search input -->
        <div class="relative max-w-xs">
            <label for="hs-table-search" class="sr-only">Search</label>
            <input x-model="searchQuery" type="text" name="hs-table-search" id="hs-table-search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Search for items">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </div>
        {{ $newData }}
    </div>
    <!-- Table Header Slot -->
    <div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                {{ $header }}
            </thead>
            <tbody>
                <!-- Table Body Slot -->
                {{ $body }}
            </tbody>
        </table>
    </div>

    <div class="py-1 px-4" x-show="totalPages > 1">
        <nav class="flex items-center space-x-1">
            <button @click="prevPage" :disabled="currentPage === 1" type="button" class="p-2.5 inline-flex items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <span aria-hidden="true">«</span>
                <span class="sr-only">Previous</span>
            </button>
            <template x-for="page in pages" :key="page">
                <button @click="changePage(page)" :class="{ 'font-bold': currentPage === page }" class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10" x-text="page"></button>
            </template>
            <button @click="nextPage" :disabled="currentPage === totalPages" type="button" class="p-2.5 inline-flex items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <span class="sr-only">Next</span>
                <span aria-hidden="true">»</span>
            </button>
        </nav>
    </div>
</div>
<script>
    function getPaginationRange(totalItems, itemsPerPage, currentPage) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const pageRange = 3;
        let startPage = Math.max(currentPage - Math.floor(pageRange / 2), 1);
        let endPage = startPage + pageRange - 1;

        if (endPage > totalPages) {
            endPage = totalPages;
            startPage = Math.max(endPage - pageRange + 1, 1);
        }

        return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
    }

    function paginateData(data, itemsPerPage, currentPage) {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        if (startIndex >= data.length) {
            return data;
        }
        return data.slice(startIndex, Math.min(endIndex, data.length));
    }

    function initPagination(data, filterFields) {
        console.log(data);
        data = data.map((row, index) => ({ ...row, number: index + 1 }));
        console.log(data);
        return {
            currentPage: 1,
            itemsPerPage: 5,
            searchQuery: '',
            rows: data,
            get filteredRows() {
                const query = this.searchQuery.toLowerCase();
                return this.rows.filter(row => {
                    return filterFields.some(field => {
                        const properties = field.split('.');
                        const value = properties.reduce((obj, prop) => obj && obj[prop], row);

                        if (Array.isArray(value)) {
                            // Handle nested arrays (e.g., branches and roles)
                            return value.some(item => {
                                if (typeof item === 'object' && item !== null) {
                                    // Handle nested objects within arrays
                                    return Object.values(item).some(val => typeof val === 'string' && val.toLowerCase().includes(query));
                                } else if (typeof item === 'string') {
                                    return item.toLowerCase().includes(query);
                                }
                                return false;
                            });
                        } else if (typeof value === 'string') {
                            // Handle string values
                            return value.toLowerCase().includes(query);
                        }

                        return false;
                    });
                });
            },

            get paginatedData() {
                return paginateData(this.filteredRows, this.itemsPerPage, this.currentPage);
            },
            get totalPages() {
                return Math.ceil(this.filteredRows.length / this.itemsPerPage);
            },
            get pages() {
                return getPaginationRange(this.filteredRows.length, this.itemsPerPage, this.currentPage);
            },
            changePage(page) {
                this.currentPage = page;
            },
            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage += 1;
                }
            },
            prevPage() {
                if (this.currentPage > 1) {
                    this.currentPage -= 1;
                }
            },
        };
    }
</script>