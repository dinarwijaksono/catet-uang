@extends('../layout/main')

@section('main')
    <section class="py-2 px-4 m-4 rounded flex justify-end">
        <div class="basis-2/12">
            <a href="/" class="btn btn-sm btn-warning w-full">Kembali</a>
        </div>
    </section>

    @livewire('component.alert-success')
    @livewire('component.alert-danger')

    @livewire('transaction.form-create-transaction', ['date' => date('Y-m-d', $date)])
    @livewire('transaction.form-update-transaction', ['date' => date('Y-m-d', $date)])

    @livewire('transaction.box-transaction-in-date', ['date' => date('Y-m-d', $date)])
@endsection
