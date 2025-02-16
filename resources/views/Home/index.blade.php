@extends('../layout/main')

@section('main')
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
            <button class="btn btn-sm btn-primary">Tambah transaksi baru</button>
        </div>
    </section>

    <section>
        @for ($i = 0; $i < 10; $i++)
            <div
                class="bg-base-200 py-2 px-4 m-4 mb-1 rounded grid grid-cols-4 grid-rows-2 gap-2 shadow-base-100 shadow-xl">

                <div class="row-span-2 text-center">
                    <button class="btn w-full h-full">Senin, <br> 12 Maret 2024</button>
                </div>

                <div class="row-span-1 col-span-2 flex">
                    <div class="basis-6/12">Pemasukan</div>
                    <div class="basis-6/12 text-end text-success">10.000</div>
                </div>

                <div class="row-span-2 p-2">
                    <a class="btn w-full h-full btn-primary btn-sm">Detail</a>
                </div>

                <div class="row-span-1 col-span-2 flex">
                    <div class="basis-6/12">Pengeluaran</div>
                    <div class="basis-6/12 text-end text-error">10.000</div>
                </div>
            </div>
        @endfor
    </section>
@endsection
