@extends('modern-art.layout.main')

@section('main-secton')
    @livewire('modern-art.transaction.transaction-in-date', ['date' => date('Y-m-d', time())])

    @livewire('modern-art.transaction.daily-transaction-summary')

    @livewire('modern-art.transaction.create-transaction-modal', ['date' => date('Y-m-d', time())])
@endsection
