<div class="m-4 mb-3 flex justify-center">
    <section class="bg-white w-full md:w-9/12 p-4 shadow shadow-slate-500">

        @foreach ($dailyTransaction as $transaction)
            <div class="flex w-full border-b border-slate-300 hover:bg-slate-100 mb-2">
                <div class="bg-green-500 text-slate-800 p-2 text-[13px] md:text-[14px] text-center items-center w-3/12">
                    {{ $nameDays[date('N', strtotime($transaction->date))] }}
                    <br>
                    {{ date('d F', strtotime($transaction->date)) }}
                </div>

                <div class=" w-7/12 p-2">
                    <table class="text-sm w-full">
                        <tbody>
                            <tr>
                                <td class="w-5/12">Pemasukan</td>
                                <td class="w-2/12 text-center">:</td>
                                <td class="w-5/12 text-right text-success">
                                    {{ number_format($transaction->total_income) }}
                                </td>
                            </tr>

                            <tr>
                                <td>Pengeluaran</td>
                                <td class="w-2/12 text-center">:</td>
                                <td class="w-5/12 text-right text-error">
                                    {{ number_format($transaction->total_spending) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex w-2/12 px-2 justify-center items-center">
                    <a href="/home/transaction-detail/{{ date('Y-M-d', strtotime($transaction->date)) }}/modern-art"
                        class="btn btn-sm btn-outline btn-success w-full">Detail</a>
                </div>
            </div>
        @endforeach

    </section>
</div>
