<!-- Sidenav -->
<div id="docs-sidenav" class="w-64 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6">
        <a class="flex-none text-xl font-semibold dark:text-white" href="#" aria-label="Brand">KelontongSystem</a>
    </div>
    <nav class="hs-accordion-group p-2 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
        <ul class="space-y-2.5">
            <x-side-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Dashboard
            </x-side-nav-link>
            @hasrole('admin')
            <x-side-nav-link :href="route('admin.mahasiswa')" :active="request()->routeIs('admin.mahasiswa')">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Kelola Mahasiswa
            </x-side-nav-link>
            <x-side-nav-link :href="route('admin.mahasiswa')" :active="request()->routeIs('admin.mahasiswa')">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                List Proposal
            </x-side-nav-link>
            <x-side-nav-link :href="route('admin.kp')" :active="request()->routeIs('admin.kp')">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                KP
            </x-side-nav-link>
            <x-side-nav-link :href="route('admin.kp.lists')" :active="request()->routeIs('admin.kp.lists')">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Kelola Data KP
            </x-side-nav-link>
            @endhasrole
        </ul>
    </nav>
</div>