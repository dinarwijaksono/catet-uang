<section class="bg-base-200 py-2 px-4 m-4 rounded shadow">
    <div class="overflow-x-auto">
        <h1 class="text-xl mb-4">Rincian pemasukan / pengeluaran</h1>

        <div class="flex mb-4 gap-2 p-2">
            <div class="basis-10/12">

                <select wire:model="period" class="select select-sm select-primary w-full ">
                    <option value="all">Semua (periode)</option>

                    @foreach ($listPeriod as $key)
                        <option value="{{ $key->id }}">{{ $key->period_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="basis-2/12">
                <button wire:click="doChangePeriod" class="btn btn-sm btn-primary w-full">Cari</button>
            </div>
        </div>

        <div class="stats stats-horizontal w-full mb-4">
            <div class="stat text-center">
                <div class="stat-title text-success">Pemasukan</div>
                <div class="stat-value text-success">
                    {{ number_format($totalIncome) }}
                </div>
            </div>

            <div class="stat text-center">
                <div class="stat-title text-error">Pengeluaran</div>
                <div class="stat-value text-error">
                    {{ number_format($totalSpending) }}
                </div>
            </div>

            <div class="stat text-center">
                <div @class([
                    'stat-title',
                    'text-success' => $diff > 0,
                    'text-error' => $diff < 0,
                ])>Selisih</div>
                <div @class([
                    'stat-value',
                    'text-success' => $diff > 0,
                    'text-error' => $diff < 0,
                ])>
                    {{ number_format($diff) }}
                </div>
            </div>
        </div>

        <div>
            <progress class="progress progress-success bg-error w-full"
                value="{{ $summaryTotal->total_income == 0 ? 0 : round(($diff / $totalIncome) * 100) }}"
                max="100"></progress>
        </div>


    </div>
</section>
