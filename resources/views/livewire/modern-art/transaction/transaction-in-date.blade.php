<div class="m-4 mb-3 flex justify-center">
    <section class="bg-base-100 w-full md:w-9/12 p-4 shadow shadow-slate-500">
        <p class="text-slate-700 text-sm mb-4">{{ date('d F Y', strtotime($date)) }}</p>

        <table class="table table-sm md:table-md mb-4">
            <tbody>
                @foreach ($transactions as $key)
                    <tr v-for="key in transactions" class="border-b border-slate-300 hover:bg-base-200">
                        <td>
                            <a href="#" class="no-underline text-primary">{{ $key->category_name }}</a> -
                            {{ $key->description }}
                        </td>

                        <td @class([
                            'text-right',
                            'text-error' => $key->income == 0,
                            'text-success' => $key->spending == 0,
                        ])>
                            {{ number_format($key->income == 0 ? $key->spending : $key->income) }}
                        <td>
                            <button type="button" class="btn btn-xs btn-error text-white w-full">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-center">
            <router-link to="/transaction/create" class="btn btn-sm btn-primary w-4/12">Tambah Transaksi</router-link>
        </div>

    </section>
</div>
