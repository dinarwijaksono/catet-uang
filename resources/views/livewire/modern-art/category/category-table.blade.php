<div class="m-4 mb-3 flex justify-center">
    <section class="bg-base-100 w-full md:w-9/12 p-4 shadow shadow-slate-500">

        <div class="flex justify-between">
            <h1 class="mb-8 text-xl text-slate-700">List Kategori</h1>

            <button class="btn btn-xs md:btn-sm btn-primary">Tambah</button>
        </div>

        <table class="table table-sm md:table-md">
            <thead>
                <tr class="bg-yellow-100 border-b border-slate-300">
                    <th class="text-center md:w-1/12 hidden md:block">No</th>
                    <th class="text-center w-4/12 md:w-5/12">Nama</th>
                    <th class="text-center w-4/12 md:w-3/12">Type</th>
                    <th class="text-center w-4/12 md:w-3/12">#</th>
                </tr>
            </thead>

            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr class="hover:bg-base-200 border-b last:border-0 border-slate-300">
                        <td class="text-center hidden md:block">{{ $i + 1 }}</td>
                        <td>Makanan</td>
                        <td class="text-center">
                            <div class="badge badge-sm badge-error text-white">
                                Pengeluaran
                            </div>
                        </td>
                        <td class="flex justify-center gap-2">
                            <button class="btn btn-xs btn-info w-full md:w-6/12">Detail</button>
                            <button class="btn btn-xs btn-error text-white md:w-6/12 hidden md:block">Hapus</button>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </section>
</div>
