<!doctype html>
<html lang="en" data-theme="corporate">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/svg+xml" href="/icon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME') }}</title>

    @vite('resources/css/app.css')
</head>

<body>
    <main class="bg-slate-300 h-screen w-full flex justify-center">

        <section class="bg-base-200 w-full min-h-screen overflow-scroll">

            <nav class="w-full bg-green-400 shadow">
                <div class="p-2 md:px-12 flex justify-between items-center">
                    <h1>
                        <a class="btn btn-link no-underline text-slate-500 text-xl">Dinar</a>
                    </h1>

                    <button class="btn btn-xs md:btn-sm btn-error text-white">Logout</button>
                </div>

                <div class="divider my-0 mx-2 md:mx-8"></div>

                <div class="flex justify-center">
                    @php
                        $path = isset($_SERVER['REQUEST_URI']) ? explode('/', $_SERVER['REQUEST_URI'])[1] : '';
                    @endphp

                    <div class="py-2 px-14 w-full md:w-6/12 flex justify-center gap-2">
                        <a href="/" class="btn btn-sm btn-primary btn-outline w-4/12">Home</a>
                        <a href="/report" class="btn btn-sm btn-primary btn-outline w-4/12">Laporan</a>
                        <a href="/setting/modern-art" @class([
                            'btn btn-sm btn-primary w-4/12',
                            'btn-outline' => $path != 'setting',
                        ])>Setting</a>
                    </div>
                </div>
            </nav>

            <div class=" py-4 px-4 flex justify-center">
                <section class="bg-base-100 w-full md:w-9/12 p-4 shadow shadow-slate-500">

                    <div class="flex justify-between">
                        <h1 class="mb-8 text-xl text-slate-700">List Kategori</h1>

                        <button class="btn btn-xs md:btn-sm btn-primary">Tambah</button>
                    </div>

                    <table class="table table-sm md:table-md">
                        <thead>
                            <tr class="bg-yellow-100 border-b border-slate-300">
                                <th class="text-center md:w-1/12 hidden md:block">No</th>
                                <th class="text-center w-4/12 md:w-5/12">Nama</th>
                                <th class="text-center w-4/12 md:w-3/12">Type</th>
                                <th class="text-center w-4/12 md:w-3/12">#</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for ($i = 0; $i < 10; $i++)
                                <tr class="hover:bg-base-200 border-b last:border-0 border-slate-300">
                                    <td class="text-center hidden md:block">{{ $i + 1 }}</td>
                                    <td>Makanan</td>
                                    <td class="text-center">
                                        <div class="badge badge-sm badge-error text-white">
                                            Pengeluaran
                                        </div>
                                    </td>
                                    <td class="flex justify-center gap-2">
                                        <button class="btn btn-xs btn-info w-full md:w-6/12">Detail</button>
                                        <button
                                            class="btn btn-xs btn-error text-white md:w-6/12 hidden md:block">Hapus</button>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>

                </section>
            </div>

        </section>

    </main>
</body>

</html>
