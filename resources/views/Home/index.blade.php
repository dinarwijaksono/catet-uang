@extends('../layout/main')

@section('main')
    @livewire('component.alert-success')
    @livewire('component.alert-danger')

    @livewire('transaction.form-create-transaction', ['date' => date('Y-m-d')])
    @livewire('transaction.form-update-transaction', ['date' => date('Y-m-d')])

    @livewire('transaction.box-transaction-in-date', ['date' => date('Y-m-d')])

    <section>
        @for ($i = 0; $i < 10; $i++)
            <div class="bg-base-200 py-2 px-4 m-4 mb-1 rounded grid grid-cols-4 grid-rows-2 gap-2 shadow-base-100 shadow-xl">

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
