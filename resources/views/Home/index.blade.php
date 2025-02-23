@extends('../layout/main')

@section('main')
    @livewire('component.alert-success')
    @livewire('component.alert-danger')

    @livewire('transaction.form-create-transaction', ['date' => date('Y-m-d')])
    @livewire('transaction.form-update-transaction', ['date' => date('Y-m-d')])

    @livewire('transaction.box-transaction-in-date', ['date' => date('Y-m-d')])

    @livewire('transaction.box-summary-income-spending')
@endsection
