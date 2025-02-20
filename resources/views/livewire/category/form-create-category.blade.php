<div @class([
    'fixed bg-slate-50/20 top-0 right-0 left-0 bottom-0 w-full px-4 md:px-60 z-50 overflow-y-scroll',
    'hidden' => $hidden,
])>

    <div class="bg-base-300 shadow-xl mt-40 px-8 py-8 rounded-md">
        <h2 class="text-center text-2xl mb-4">Buat kategori</h2>

        <div class="mb-4">
            <label for="categoryName">Nama kategori</label>
            <input type="text" wire:model="name" placeholder="Kategori"
                class="input input-bordered w-full input-sm my-2" />

            @error('name')
                <p class="text-error italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="type">Type</label>

            <div class="flex gap-4 my-2">
                <button type="button" wire:click="doChangeType('income')"
                    @class([
                        'btn btn-sm btn-success w-6/12',
                        'btn-outline' => $type != 'income',
                    ])>Pemasukan</button>

                <button type="button" wire:click="doChangeType('spending')"
                    @class([
                        'btn btn-sm btn-warning w-6/12',
                        'btn-outline' => $type != 'spending',
                    ])>Pengeluaran</button>
            </div>

            @error('type')
                <p class="text-error italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="card-actions justify-end flex mt-10 gap-4">
            <button type="button" wire:click="doHide" class="btn btn-error btn-sm w-3/12">Batal</button>
            <button type="button" wire:click="save" class="btn btn-primary btn-sm w-3/12">Simpan</button>
        </div>
    </div>

</div>
