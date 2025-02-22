<section class="bg-base-200 py-2 px-4 m-4 rounded shadow-xl">
    <p class="text-end text-sm">Senin, 10 November 2023</p>

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
                <!-- row 1 -->
                <tr class="bg-base-200">
                    <td><a class="link link-success">Makanan</a></td>
                    <td>Makan siang</td>
                    <td class="text-end text-error">10.000</td>
                    <td class="flex gap-2">
                        <div class="basis-6/12">
                            <button class="btn btn-sm btn-primary w-full">Edit</button>
                        </div>

                        <div class="basis-6/12">
                            <button class="btn btn-sm btn-error w-full">Hapus</button>
                        </div>
                    </td>
                </tr>

                <tr class="bg-base-200">
                    <td><a class="link link-success">Dikasih</a></td>
                    <td>Bapa</td>
                    <td class="text-end text-success">100.000</td>
                    <td class="flex gap-2">
                        <div class="basis-6/12">
                            <button class="btn btn-sm btn-primary w-full">Edit</button>
                        </div>

                        <div class="basis-6/12">
                            <button class="btn btn-sm btn-error w-full">Hapus</button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="text-center">
        <button wire:click="doShowFormCreateTransaction" class="btn btn-sm btn-primary">Tambah transaksi baru</button>
    </div>
</section>
