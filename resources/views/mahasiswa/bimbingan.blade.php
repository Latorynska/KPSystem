<x-app-layout>
    <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
            <p>Silahkan untuk bergabug dengan grup sosial media yang diberikan dosen pembimbing anda</p>
            <a class="underline text-blue-200" href="{{ $kp->pembimbing->grup_bimbingan->link_grup }}">{{ $kp->pembimbing->grup_bimbingan->link_grup }}</a>
        </div>
    </div>
</x-app-layout>