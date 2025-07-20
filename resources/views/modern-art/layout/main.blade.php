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

            @livewire('modern-art.component.navbar')

            @if (env('APP_ENV') == 'local')
                <div class="bg-error text-center p-2">
                    <p class="text-xs italic underline text-white font-bold">Aplikasi ini berjalan pada mode Testting!!!
                    </p>
                </div>
            @endif

            @yield('main-section')

        </section>

    </main>
</body>

</html>
