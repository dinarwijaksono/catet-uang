<nav class="w-full bg-green-400 shadow">
    <div class="p-2 md:px-12 flex justify-between items-center">
        <h1>
            <a class="btn btn-link no-underline text-slate-500 text-xl">{{ auth()->user()->name }}</a>
        </h1>

        <button type="button" wire:click="hendleButtonLogout"
            class="btn btn-xs md:btn-sm btn-error text-white">Logout</button>
    </div>

    <div class="divider my-0 mx-2 md:mx-8"></div>

    <div class="flex justify-center">
        @php
            $path = isset($_SERVER['REQUEST_URI']) ? explode('/', $_SERVER['REQUEST_URI'])[1] : '';
        @endphp

        <div class="py-2 px-14 w-full md:w-6/12 flex justify-center gap-2">
            <a href="/modern-art" @class([
                'btn btn-sm btn-primary w-4/12',
                'btn-outline' => $path != 'modern-art',
            ])>Home</a>

            <a href="/report/modern-art" @class([
                'btn btn-sm btn-primary w-4/12',
                'btn-outline' => $path != 'report',
            ])>Laporan</a>

            <a href="/setting/modern-art" @class([
                'btn btn-sm btn-primary w-4/12',
                'btn-outline' => $path != 'setting',
            ])>Setting</a>
        </div>
    </div>

    <script src="/sweetalert/sweetalert.js"></script>
    <script>
        window.addEventListener('open-confirm-logout', event => {
            Swal.fire({
                title: "Kamu yakin ingin Logout?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Logout!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('do-logout')
                }
            });
        })
    </script>
</nav>
