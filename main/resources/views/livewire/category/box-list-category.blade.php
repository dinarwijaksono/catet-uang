<section class="bg-base-200 py-2 px-4 m-4 rounded shadow-xl">
    <div class="overflow-x-auto">
        <h1 class="text-xl mb-4">List Kategori</h1>

        <div class="flex justify-end py-4">
            <button type="button" wire:click="toShowFormCreateCategory" class="btn btn-sm btn-primary w-2/12">
                <span wire:loading.remove wire:target="toShowFormCreateCategory">Buat kategori
                    baru</span>

                <span wire:loading wire:target="toShowFormCreateCategory" class="loading loading-dots loading-md"></span>
            </button>
        </div>

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

                @foreach ($listCategory as $category)
                    <tr class="bg-base-200 hover:bg-base-300">
                        <td class="hidden md:block text-center">{{ $loop->iteration }}</td>
                        <td>{{ $category['name'] }}</td>
                        <td class="text-center">
                            <div @class([
                                'badge rounded text-[13px]',
                                'badge-success' => $category['type'] == 'income',
                                'badge-error' => $category['type'] == 'spending',
                            ])>
                                {{ $category['type'] == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</div>
                        </td>
                        <td class="text-center">{{ date('j F Y', strtotime($category['created_at'])) }}</td>
                        <td>
                            <div class="flex gap-2">

                                <div class="basis-6/12">
                                    <button type="button"
                                        wire:click="doShowFormUpdateCategory('{{ $category['code'] }}')"
                                        class="btn btn-sm w-full btn-primary">
                                        <span wire:loading.remove
                                            wire:target="doShowFormUpdateCategory('{{ $category['code'] }}')">Edit</span>

                                        <span wire:loading
                                            wire:target="doShowFormUpdateCategory('{{ $category['code'] }}')"
                                            class="loading loading-dots loading-md"></span>
                                    </button>
                                </div>

                                <div class="basis-6/12">
                                    <button wire:target="deleteCategory('{{ $category['code'] }}')" type="button"
                                        wire:click="deleteCategory('{{ $category['code'] }}')"
                                        class="btn btn-sm w-full btn-error">

                                        <span wire:loading wire:target="deleteCategory('{{ $category['code'] }}')"
                                            class="loading loading-dots loading-md"></span>

                                        <span wire:loading.class="hidden"
                                            wire:target="deleteCategory('{{ $category['code'] }}')">Hapus</span>
                                    </button>
                                </div>

                            </div>

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
</section>
