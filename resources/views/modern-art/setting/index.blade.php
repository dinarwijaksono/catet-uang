@extends('modern-art.layout.main')

@section('main-secton')
    @livewire('modern-art.category.category-table')

    @livewire('modern-art.category.create-category-modal')
@endsection
