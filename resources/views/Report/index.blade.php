@extends('../layout/main')

@section('main')
    @livewire('report.box-summary-total')

    <div class="divider px-4">***</div>

    <section class="bg-base-200 py-2 px-4 m-4 rounded shadow">
        <div class="overflow-x-auto">
            <h1 class="text-xl mb-4">Transaksi perperiode</h1>

            <div class="flex mb-4 gap-2 p-2">
                <div class="basis-10/12">

                    <select class="select select-sm select-primary w-full ">
                        <option>Januari 2025</option>
                        <option>Februari 2025</option>
                    </select>
                </div>

                <div class="basis-2/12">
                    <button class="btn btn-sm btn-primary w-full">Cari</button>
                </div>
            </div>

            <table class="table mb-4">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="hidden md:block w-1/12"></th>
                        <th class="w-5/12">Kategori</th>
                        <th class="text-right w-3/12">Pemasukan</th>
                        <th class="text-right w-3/12">Peneluaran</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="bg-base-200 hover:bg-base-300">
                        <td class="text-center">1</td>
                        <td>Makanan</td>
                        <td class="text-right text-success">-</td>
                        <td class="text-right text-error">10.000</td>
                    </tr>

                    <tr class="bg-base-200 hover:bg-base-300">
                        <td class="text-center">1</td>
                        <td>Gaji</td>
                        <td class="text-right text-success">200.0000.000</td>
                        <td class="text-right text-error">-</td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr class="text-[14px]">
                        <td colspan="2" class="text-center text-bold">TOTAL</td>
                        <td class="text-right text-success">200.0000.000</td>
                        <td class="text-right text-error">-</td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </section>

    <div class="divider px-4">***</div>

    <section class="bg-base-200 py-2 px-4 m-4 rounded shadow">
        <div class="overflow-x-auto">
            <h1 class="text-xl mb-4">Transaksi Perkategori</h1>

            <div class="flex mb-4 gap-2 p-2">

                <div class="basis-5/12">
                    <select class="select select-sm select-primary w-full ">
                        <option>Januari 2025</option>
                        <option>Februari 2025</option>
                    </select>
                </div>

                <div class="basis-5/12">
                    <select class="select select-sm select-primary w-full ">
                        <option>Makanan</option>
                        <option>Gaji</option>
                    </select>
                </div>

                <div class="basis-2/12">
                    <button class="btn btn-sm btn-primary w-full">Cari</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra mb-4">
                    <thead>
                        <tr>
                            <th class="w-2/12 text-center">Tanggal</th>
                            <th class="w-3/12">Kategori</th>
                            <th class="w-3/12">Deskripsi</th>
                            <th class="text-right w-1/12">Pemasukan</th>
                            <th class="text-right w-1/12">Peneluaran</th>
                            <th class="w-2/12"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <td class="text-center">1 Januari 2025</td>
                                <td>Makanan</td>
                                <td>Makan siang</td>
                                <td class="text-right text-success">-</td>
                                <td class="text-right text-error">10.000</td>
                                <td>
                                    <div class="flex gap-2">
                                        <div class="basis-6/12">
                                            <button class="btn btn-sm btn-primary w-full">Edit</button>
                                        </div>

                                        <div class="basis-6/12">
                                            <button class="btn btn-sm btn-error w-full">Hapus</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>

                    <tfoot>
                        <tr class="text-[14px]">
                            <th colspan="3" class="w-2/12 text-center">TOTAL</th>
                            <th class="text-right w-1/12 text-success">10.000</th>
                            <th class="text-right w-1/12 text-error">10.000</th>
                            <th class="w-2/12"></th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </section>
@endsection
