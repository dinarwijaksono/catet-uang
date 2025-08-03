<div class="m-4 mb-3 flex justify-center">
    <section class="bg-white w-full md:w-9/12 p-4 shadow shadow-slate-500 ">

        <div class="flex mb-4">
            <div class="w-10/12 p-2">
                <select wire:model="periodSelect" class="select bg-slate-200 w-full">
                    <option value="all">semua periode</option>

                    @foreach ($periods as $key)
                        <option value="{{ $key->id }}">{{ $key->period_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-2/12 p-2 flex items-center">
                <button type="button" wire:click="hendleButtonSearchByPeriod"
                    class="btn btn-success w-full">Cari</button>
            </div>
        </div>

        <div class="w-full border border-slate-300 bg-slate-200 shadow rounded-md overflow-hidden">
            <table class="table w-full">
                <thead>
                    <tr class="text-center md:text-xl">
                        <th class="text-success">Pemasukan</th>
                        <th class="text-error">Pengeluaran</th>
                        <th @class([
                            'text-success' => $difference > 0,
                            'text-error' => $difference < 0,
                        ])>Selisih</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="text-center text-2xl md:text-5xl font-bold">
                        <td class="text-success">{{ number_format($transactionSummary->total_income) }}</td>
                        <td class="text-error">{{ number_format($transactionSummary->total_spending) }}</td>
                        <td @class([
                            'text-success' => $difference > 0,
                            'text-error' => $difference < 0,
                        ])>{{ number_format($difference) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>


    </section>
</div>
