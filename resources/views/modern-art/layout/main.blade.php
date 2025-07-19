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
                        <a class="btn btn-link no-underline text-slate-500 text-xl">{{ auth()->user()->name }}</a>
                    </h1>

                    <button class="btn btn-xs md:btn-sm btn-error text-white">Logout</button>
                </div>

                <div class="divider my-0 mx-2 md:mx-8"></div>

                <div class="flex justify-center">
                    @php
                        $path = isset($_SERVER['REQUEST_URI']) ? explode('/', $_SERVER['REQUEST_URI'])[1] : '';
                    @endphp

                    <div class="py-2 px-14 w-full md:w-6/12 flex justify-center gap-2">
                        <a href="/modern-art" @class([
                            'btn btn-sm btn-primary w-4/12',
                            'btn-outline' => $path != 'modern-art',
                        ])>Home</a>
                        <a href="/report" class="btn btn-sm btn-primary btn-outline w-4/12">Laporan</a>
                        <a href="/setting/modern-art" @class([
                            'btn btn-sm btn-primary w-4/12',
                            'btn-outline' => $path != 'setting',
                        ])>Setting</a>
                    </div>
                </div>
            </nav>

            @yield('main-section')

        </section>

    </main>
</body>

</html>
