<div class="m-4 mb-3 flex justify-center">
    <section class="bg-white w-full md:w-9/12 p-4 shadow shadow-slate-500">
        <p class="text-slate-800 text-sm mb-4">{{ date('d F Y', strtotime($date)) }}</p>

        <table class="table table-sm md:table-md mb-4">
            <tbody>
                @foreach ($transactions as $key)
                    <tr v-for="key in transactions" class="border-b border-slate-300 hover:bg-slate-100">
                        <td>
                            <a href="#" class="no-underline text-primary">{{ $key->category_name }}</a> -
                            {{ $key->description }}
                        </td>

                        <td @class([
                            'text-right',
                            'text-error' => $key->income == 0,
                            'text-success' => $key->spending == 0,
                        ])>
                            {{ number_format($key->income == 0 ? $key->spending : $key->income) }}
                        <td>
                            <button type="button" wire:click="hendleButtonDeleteTransaction('{{ $key->code }}')"
                                class="btn btn-xs btn-error text-white w-full">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-center">
            <button type="button" wire:click="hendleShowCreateTransactionModal"
                class="btn btn-sm btn-primary w-4/12">Tambah Transaksi</button>
        </div>

    </section>

    <script src="/sweetalert/sweetalert.js"></script>
    <script>
        window.addEventListener('open-confirm-delete-transaction', event => {
            Swal.fire({
                title: "Kamu yakin ingin menghapus transaksi?",
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

        window.addEventListener('show-delete-transaction-success', event => {
            Swal.fire({
                title: 'Berhasil',
                text: "Transaksi berhasil dihapus",
                icon: 'success'
            })
        })
    </script>
</div>
