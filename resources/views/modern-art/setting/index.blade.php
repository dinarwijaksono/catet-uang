@extends('modern-art.layout.main')

@section('main-section')
    @livewire('modern-art.category.category-table')

    @livewire('modern-art.category.create-category-modal')

    @livewire('modern-art.setting.file-import-form')
@endsection
