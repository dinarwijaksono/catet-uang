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
    <main class="flex justify-center items-center bg-base-200">
        @livewire('modern-art.auth.login-form')
    </main>
</body>

</html>
