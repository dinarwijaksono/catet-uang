@extends('modern-art.layout.main')

@section('main-section')
    @livewire('modern-art.report.income-spending-summary')

    @livewire('modern-art.report.category-transaction-report-table')
@endsection
