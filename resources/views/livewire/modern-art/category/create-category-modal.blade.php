<div @class([
    'fixed top-0 right-0 bottom-0 left-0 bg-slate-300/70 justify-center items-center',
    'flex' => $isOpen,
    'hidden' => !$isOpen,
])>
    <section class="bg-white w-full mx-4 md:w-6/12 p-4 md:px-8 md:py-4 shadow shadow-slate-500 rounded">

        <h1 class="text-center text-xl font-medium">Buat kategori</h1>

        <div class="mb-4">
            <label class="mb-2 text-slate-700">Name</label>
            <input type="text" wire:model="name" class="input input-sm w-full" placeholder="Nama kategori">

            @error('name')
                <p class="text-error italic text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2 text-slate-700">Type</label>
            <div class="flex justify-center gap-2">
                <button type="button" wire:click="setType('income')" @class([
                    'btn btn-sm btn-success basis-6/12',
                    'btn-outline' => $type != 'income',
                ])>Pemasukan</button>

                <button type="button" wire:click="setType('spending')"
                    @class([
                        'btn btn-sm btn-error basis-6/12',
                        'btn-outline' => $type != 'spending',
                    ])>pengeluaran</button>
            </div>

            @error('type')
                <p class="text-error italic text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2">
            <button type="button" wire:click="setHidden" class="btn btn-sm btn-error text-white">Batal</button>
            <button type="button" wire:click="save" class="btn btn-sm btn-primary">Simpan</button>
        </div>

    </section>

    <script src="/sweetalert/sweetalert.js"></script>
    <script>
        window.addEventListener('show-create-category-success', event => {
            Swal.fire({
                title: 'Berhasil',
                text: "Kategori berhasil disimpan",
                icon: 'success',
                didClose: () => {
                    Livewire.dispatch('set-hide')

                    Livewire.dispatchTo('modern-art.category.category-table', 'do-refresh')
                }
            })
        })

        window.addEventListener('show-create-category-failed', event => {
            Swal.fire({
                title: 'Gagal',
                text: "Kategori gagal disimpan.",
                icon: 'error'
            })
        })
    </script>

</div>
