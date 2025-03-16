<section class="bg-base-200 py-2 px-4 m-4 rounded shadow">
    <div class="overflow-x-auto">
        <h1 class="text-xl mb-4">Transaksi total perkategori</h1>

        <div class="flex mb-4 gap-2 p-2">
            <div class="basis-10/12">

                <select wire:model="period" class="select select-sm select-primary w-full ">
                    @foreach ($listPeriod as $key)
                        <option value="{{ $key->id }}">{{ $key->period_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="basis-2/12">
                <button type="button" wire:click="doChangePeriod" class="btn btn-sm btn-primary w-full">Cari</button>
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
                @php
                    $grandTotalIncome = 0;
                    $grandTotalSpending = 0;
                @endphp

                @if (!is_null($period))
                    @foreach ($listTotalCategory as $transaction)
                        @php
                            $grandTotalIncome += $transaction->total_income;
                            $grandTotalSpending += $transaction->total_spending;
                        @endphp
                        <tr class="bg-base-200 hover:bg-base-300">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $transaction->category_name }}</td>
                            <td class="text-right text-success">
                                {{ $transaction->total_income == 0 ? '-' : number_format($transaction->total_income) }}
                            </td>
                            <td class="text-right text-error">
                                {{ $transaction->total_spending == 0 ? '-' : number_format($transaction->total_spending) }}
                            </td>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>

            <tfoot>
                <tr class="text-[14px]">
                    <td colspan="2" class="text-center text-bold">TOTAL</td>
                    <td class="text-right text-success">
                        {{ $grandTotalIncome == 0 ? '-' : number_format($grandTotalIncome) }}
                    </td>
                    <td class="text-right text-error">
                        {{ $grandTotalSpending == 0 ? '-' : number_format($grandTotalSpending) }}
                    </td>
                </tr>
            </tfoot>

        </table>
    </div>
</section>
