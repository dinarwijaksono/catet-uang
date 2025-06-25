<section class="bg-base-200 py-2 px-4 m-4 rounded shadow-xl">
    @foreach ($summaryIncomeSpending as $key)
        <div class="bg-base-200 py-2 px-4 m-4 mb-1 rounded grid grid-cols-4 grid-rows-2 gap-2 shadow-base-100 shadow-xl">

            <div class="row-span-2 text-center">
                <button class="btn w-full h-full">{{ date('j F Y', strtotime($key->date)) }}</button>
            </div>

            <div class="row-span-1 col-span-2 flex">
                <div class="basis-6/12">Pemasukan</div>
                <div class="basis-6/12 text-end text-success">{{ number_format($key->total_income) }}</div>
            </div>

            <div class="row-span-2 p-2">
                <a href="/home/detail-transaction/{{ strtotime($key->date) }}"
                    class="btn w-full h-full btn-primary btn-sm">Detail</a>
            </div>

            <div class="row-span-1 col-span-2 flex">
                <div class="basis-6/12">Pengeluaran</div>
                <div class="basis-6/12 text-end text-error">{{ number_format($key->total_spending) }}</div>
            </div>
        </div>
    @endforeach
</section>
