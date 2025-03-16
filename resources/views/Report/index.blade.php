@extends('../layout/main')

@section('main')
    @livewire('component.alert-success')
    @livewire('component.alert-danger')

    @livewire('transaction.form-update-transaction', ['date' => date('Y-m-d')])

    @livewire('report.box-summary-total')

    <div class="divider px-4">***</div>

    @livewire('report.box-summary-by-category')

    <div class="divider px-4">***</div>

    @livewire('report.box-transaction-in-period')
@endsection
