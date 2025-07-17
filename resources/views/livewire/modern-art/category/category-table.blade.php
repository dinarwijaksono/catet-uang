<div class="m-4 mb-3 flex justify-center">
    <section class="bg-base-100 w-full md:w-9/12 p-4 shadow shadow-slate-500">

        <div class="flex justify-between">
            <h1 class="mb-8 text-xl text-slate-700">List Kategori</h1>

            <button type="button" wire:click="openCreateCategoryModal" class="btn btn-xs md:btn-sm btn-primary">Buat
                kategori</button>
        </div>

        <table class="table table-sm md:table-md w-full">
            <thead>
                <tr class="bg-yellow-100 border-b border-slate-300">
                    <th class="text-center md:w-1/12 hidden md:table-cell ">No</th>
                    <th class="text-center w-4/12 md:w-5/12 ">Nama</th>
                    <th class="text-center w-4/12 md:w-2/12">Type</th>
                    <th class="text-center md:w-2/12 hidden md:table-cell ">Dibuat</th>
                    <th class="text-center w-4/12 md:w-2/12">#</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories as $key)
                    <tr class="hover:bg-base-200 border-b last:border-0 border-slate-300">
                        <td class="text-center hidden md:table-cell">{{ $loop->iteration }}</td>
                        <td>{{ $key->name }}</td>
                        <td class="text-center">
                            <div @class([
                                'badge badge-sm text-white',
                                'badge-success' => $key->type == 'income',
                                'badge-error' => $key->type == 'spending',
                            ])>
                                {{ $key->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </div>
                        </td>
                        <td class="text-center hidden md:table-cell">
                            {{ date('d F Y', strtotime($key->created_at)) }}
                        </td>

                        <td class="flex justify-center gap-2">
                            <button class="btn btn-xs btn-info w-full md:w-6/12">Detail</button>
                            <button type="button" wire:click="openConfirmDelete('{{ $key->code }}')"
                                class="btn btn-xs btn-error text-white md:w-6/12 hidden md:block">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <script src="/sweetalert/sweetalert.js"></script>
    <script>
        window.addEventListener('open-confirm-delete-category', event => {
            Swal.fire({
                title: "Kamu yakin?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('do-delete', {
                        code: event.detail.code
                    })
                }
            });
        })

        window.addEventListener('show-delete-category-success', event => {
            Swal.fire({
                title: 'Berhasil',
                text: "Kategori berhasil dihapus",
                icon: 'success',
                didClose: () => {
                    Livewire.dispatch('set-hide')

                    Livewire.dispatch('do-refresh')
                }
            })
        })

        window.addEventListener('show-delete-category-failed', event => {
            Swal.fire({
                title: 'Gagal',
                text: "Kategori gagal dihapus, kategori masih digunakan.",
                icon: 'error',
                didClose: () => {
                    Livewire.dispatch('set-hide')
                }
            })
        })
    </script>
</div>
