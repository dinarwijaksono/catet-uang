<section class="bg-base-200 py-2 px-4 m-4 rounded shadow">
    <div class="overflow-x-auto">
        <h1 class="text-xl mb-4">Transaksi Perkategori</h1>

        <div class="flex mb-4 gap-2 p-2">

            <div class="basis-5/12">
                <select class="select select-sm select-primary w-full" wire:model="periodSelect">
                    @foreach ($listPeriod as $key)
                        <option value="{{ $key->id }}">{{ $key->period_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="basis-5/12">
                <select class="select select-sm select-primary w-full ">
                    <option>Makanan</option>
                    <option>Gaji</option>
                </select>
            </div>

            <div class="basis-2/12">
                <button type="button" wire:click="doChangePeriod" class="btn btn-sm btn-primary w-full">Cari</button>
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

                @php
                    $totalIncome = 0;
                    $totalSpending = 0;
                @endphp

                <tbody>
                    @if (count($this->listPeriod) != 0)
                        @foreach ($listTransaction as $key)
                            @php
                                $totalIncome += $key->income;
                                $totalSpending += $key->spending;
                            @endphp

                            <tr>
                                <td class="text-center">{{ date('d F Y', strtotime($key->date)) }}</td>
                                <td>{{ $key->category_name }}</td>
                                <td>{{ $key->description }}</td>
                                <td class="text-right text-success">
                                    {{ $key->income = 0 ? '-' : number_format($key->income) }}</td>
                                <td class="text-right text-error">
                                    {{ $key->spending = 0 ? '-' : number_format($key->spending) }}</td>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <div class="basis-6/12">
                                            <button type="button" wire:click="doShowFormUpdate('{{ $key->code }}')"
                                                class="btn btn-sm btn-primary w-full">Edit</button>
                                        </div>

                                        <div class="basis-6/12">
                                            <button type="button"
                                                wire:click="doDeleteTransaction('{{ $key->code }}')"
                                                class="btn btn-sm btn-error w-full">Hapus</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

                <tfoot>
                    <tr class="text-[14px]">
                        <th colspan="3" class="w-2/12 text-center">TOTAL</th>
                        <th class="text-right w-1/12 text-success">
                            {{ $totalIncome = 0 ? '-' : number_format($totalIncome) }}</td>
                        </th>
                        <th class="text-right w-1/12 text-error">
                            {{ $totalSpending = 0 ? '-' : number_format($totalSpending) }}</td>
                        </th>
                        <th class="w-2/12"></th>
                    </tr>
                </tfoot>


            </table>
        </div>
    </div>
</section>
