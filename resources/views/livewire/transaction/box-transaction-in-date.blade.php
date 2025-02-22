<section class="bg-base-200 py-2 px-4 m-4 rounded shadow-xl">
    <p class="text-end text-sm">{{ date('j F Y', strtotime($date)) }}</p>

    <div class="overflow-x-auto mb-4">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th class="w-3/12">Kategori</th>
                    <th class="w-4/12">Deskripsi</th>
                    <th class="w-3/12 text-end">Nilai</th>
                    <th class="w-2/12"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($listTransaction as $transaction)
                    <tr class="bg-base-200">
                        <td class="text-success">{{ $transaction->category_name }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td @class([
                            'text-end',
                            'text-error' => $transaction->spending != 0,
                            'text-success' => $transaction->income != 0,
                        ])>
                            {{ number_format($transaction->income == 0 ? $transaction->spending : $transaction->income) }}
                        </td>
                        <td class="flex gap-2">
                            <div class="basis-6/12">
                                <button class="btn btn-sm btn-primary w-full">Edit</button>
                            </div>

                            <div class="basis-6/12">
                                <button class="btn btn-sm btn-error w-full">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <div class="text-center">
        <button wire:click="doShowFormCreateTransaction" class="btn btn-sm btn-primary">Tambah transaksi baru</button>
    </div>
</section>
