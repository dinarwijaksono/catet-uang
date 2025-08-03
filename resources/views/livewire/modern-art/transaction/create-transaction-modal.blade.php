<div @class([
    'fixed top-0 right-0 bottom-0 left-0 bg-slate-300/70 justify-center items-center',
    'flex' => $isOpen,
    'hidden' => !$isOpen,
])>
    <section class="bg-white w-full mx-4 md:w-6/12 p-4 md:px-8 md:py-4 shadow shadow-slate-500 rounded">

        <h1 class="text-center text-xl font-medium">Buat Transaksi</h1>

        <div class="mb-4">
            <label class="mb-2 text-slate-700">Tanggal</label>
            <input type="date" wire:model="date" class="input input-sm w-full" placeholder="Nama kategori">

            @error('date')
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

        <div class="mb-4">
            <label class="mb-2 text-slate-700">Kategori</label>
            <select wire:model="category" id="category" class="select select-sm w-full">
                <option>-- Pilih --</option>

                @foreach ($categories as $key)
                    <option value="{{ $key->id }}">{{ $key->name }}</option>
                @endforeach
            </select>

            @error('category')
                <p class="text-error italic text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2 text-slate-700">Nilai</label>
            <input type="number" wire:model="value" wire:keyUp="setValue('{{ $value }}')" placeholder="0"
                class="input input-bordered w-full input-sm my-2" />

            <p class="text-success">{{ number_format(is_numeric($value) ? $value : 0) }}</p>

            @error('value')
                <p class="text-error italic text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2 text-slate-700">Deskripsi</label>
            <input type="text" wire:model="description" class="input input-sm w-full" placeholder="Deskripsi">

            @error('description')
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
        window.addEventListener('show-create-transaction-success', event => {
            Swal.fire({
                title: 'Berhasil',
                text: "Transaksi berhasil disimpan",
                icon: 'success',
                didClose: () => {
                    Livewire.dispatch('set-hide')

                    Livewire.dispatchTo('modern-art.transaction.transaction-in-date', 'do-refresh')
                }
            })
        })

        window.addEventListener('show-create-transaction-failed', event => {
            Swal.fire({
                title: 'Gagal',
                text: "Transaksi gagal disimpan.",
                icon: 'error'
            })
        })
    </script>

</div>
