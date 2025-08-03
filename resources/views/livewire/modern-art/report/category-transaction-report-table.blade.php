<div class="m-4 mb-3 flex justify-center">
    <section class="bg-white w-full md:w-9/12 p-4 shadow shadow-slate-500 ">

        <h1 class="text-2xl mb-4 font-semibold text-slate-600">Rincian transaksi perkategori</h1>

        <div class="flex mb-4">
            <div class="w-10/12 p-2">
                <select wire:model="periodSelect"
                    class="select bg-slate-200 w-full ring-0 outline-0 focus:outline-none focus:ring-0 focus:shadow-none focus:border-success">

                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->period_name }}</option>
                    @endforeach

                </select>
            </div>

            <div class="w-2/12 p-2 flex items-center">
                <button type="button" wire:click="doChangePeriod" class="btn btn-success w-full">Cari</button>
            </div>
        </div>

        @if (!$periods->isEmpty())
            <div class="flex justify-baseline gap-2">
                <section class="basis-6/12">
                    <div class="w-full overflow-x-auto border border-base-content/20">

                        <table class="table table-zebra table-md">
                            <thead>
                                <tr class="text-center text-success text-xl bg-green-100">
                                    <th>Kategori</th>
                                    <th>Pemasukan</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($categories->where('type', 'income') as $category)
                                    <tr class="hover:bg-green-200">
                                        <td class="text-[16px]">{{ $category->name }}</td>
                                        <td class="text-[16px] text-end text-success">
                                            @if (!$transactions->where('category_id', $category->id)->isEmpty())
                                                @php $totalIncome += $transactions->where('category_id', $category->id)->first()->total_income; @endphp
                                                {{ number_format($transactions->where('category_id', $category->id)->first()->total_income) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr class="bg-yellow-100">
                                    <td class="text-[16px] text-end font-bold">TOTAL</td>
                                    <td class="text-[16px] text-end text-success">{{ number_format($totalIncome) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </section>

                <section class="basis-6/12">
                    <div class="w-full overflow-x-auto border border-base-content/20">

                        <table class="table table-zebra table-md">
                            <thead>
                                <tr class="text-center text-success text-xl bg-red-100">
                                    <th>Kategori</th>
                                    <th class="text-error">Pengeluaran</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($categories->where('type', 'spending') as $category)
                                    <tr class="hover:bg-green-200">
                                        <td class="text-[16px]">{{ $category->name }}</td>
                                        <td class="text-[16px] text-end text-error">
                                            @if (!$transactions->where('category_id', $category->id)->isEmpty())
                                                @php $totalSpending += $transactions->where('category_id', $category->id)->first()->total_spending; @endphp
                                                {{ number_format($transactions->where('category_id', $category->id)->first()->total_spending) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr class="bg-yellow-100">
                                    <td class="text-[16px] text-end font-bold">TOTAL</td>
                                    <td class="text-[16px] text-end text-error">{{ number_format($totalSpending) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </section>
            </div>
        @endif

    </section>
</div>
