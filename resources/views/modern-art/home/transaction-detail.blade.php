@extends('modern-art.layout.main')

@section('main-section')
    @livewire('modern-art.transaction.transaction-in-date', ['date' => date('Y-m-d', $date)])

    <div class="m-4 mb-3 flex justify-center">
        <section class="w-full md:w-9/12 flex justify-end">
            <a href="/modern-art" class="btn btn-sm text-white btn-error">Kembali</a>
        </section>
    </div>

    @livewire('modern-art.transaction.create-transaction-modal', ['date' => date('Y-m-d', $date)])
@endsection
