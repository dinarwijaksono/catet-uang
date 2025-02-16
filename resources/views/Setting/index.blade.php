@extends('../layout/main')

@section('main')
    <section class="bg-base-200 py-2 px-4 m-4 rounded shadow-xl">
        <div class="overflow-x-auto">
            <h1 class="text-xl mb-4">List Kategori</h1>

            <table class="table mb-4">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="hidden md:block w-1/12"></th>
                        <th class="w-4/12">Nama</th>
                        <th class="text-center w-3/12">Type</th>
                        <th class="text-center w-3/12">Dibuat</th>
                        <th class="w-1/12"></th>
                    </tr>
                </thead>
                <tbody>

                    @for ($i = 0; $i < 10; $i++)
                        <tr class="bg-base-200 hover:bg-base-300">
                            <th class="hidden md:block text-center">{{ $i + 1 }}</th>
                            <td>Makanan</td>
                            <td class="text-center">
                                <div @class([
                                    'badge rounded p-2 text-[13px]',
                                    'badge-success' => false == 'income',
                                    'badge-error' => true == 'spending',
                                ])>Pengeluaran</div>
                            </td>
                            <td class="text-center">{{ date('j F Y') }}</td>
                            <td>
                                <div class="flex gap-2">

                                    <div class="basis-6/12">
                                        <button type="button" class="btn btn-sm w-full btn-primary">Edit</button>
                                    </div>

                                    <div class="basis-6/12">
                                        <button wire:target="delete('')" type="button" wire:click="delete('')"
                                            class="btn btn-sm w-full btn-error">
                                            {{-- <span wire:loading wire:target="delete('')"
                                        class="loading loading-dots loading-md"></span> --}}
                                            <span wire:loading.class="hidden" wire:target="delete('')">Hapus</span></button>
                                    </div>

                                </div>

                            </td>
                        </tr>
                    @endfor

                </tbody>
            </table>

            <div class="flex justify-center">
                <button type="button" wire:click="toShowBoxCreateCategory" class="btn btn-sm btn-primary">Buat kategori
                    baru</button>
            </div>

        </div>
    </section>
@endsection
