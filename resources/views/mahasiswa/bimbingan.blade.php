<x-app-layout>
    <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white text-center dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-4 mt-4">
            @if($kp->surat_bimbingan?->status_pengambilan)
                @if(isset($kp->pembimbing->grup_bimbingan))
                <p>Silahkan untuk bergabug dengan grup sosial media yang diberikan dosen pembimbing anda</p>
                <a class="underline text-blue-200" href="{{ $kp->pembimbing->grup_bimbingan->link_grup }}">{{ $kp->pembimbing->grup_bimbingan->link_grup }}</a>
                @else
                <p>Silahkan hubungi prodi untuk informasi grup dosen pembimbing</p>
                @endif
            @else
            <p>Silahkan untuk mengambil surat bimbingan ke prodi untuk melanjutkan ke proses bimbingan</p>
            @endif
        </div>
    </div>
</x-app-layout>