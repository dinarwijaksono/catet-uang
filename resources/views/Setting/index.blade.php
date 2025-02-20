@extends('../layout/main')

@section('main')
    @livewire('component.alert-success')
    @livewire('component.alert-danger')

    @livewire('category.form-create-category')

    @livewire('category.box-list-category')
@endsection
