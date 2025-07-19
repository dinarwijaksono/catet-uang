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

            @yield('main-section')

        </section>

    </main>
</body>

</html>
