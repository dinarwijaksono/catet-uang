<!DOCTYPE html>
<html lang="en" data-theme="business">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="/tailwind/style.css">
</head>

<body>

    <nav class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">Catat keuangan</a>
        </div>

        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li><a>{{ session()->get('user-name') }}</a></li>
                <li>
                    <form action="/logout" method="post">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-sm btn-error">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="flex justify-center mb-4">

        @php
            $path = isset($_SERVER['REQUEST_URI']) ? explode('/', $_SERVER['REQUEST_URI'])[1] : '';
        @endphp
        <ul class="menu bg-base-200 menu-horizontal rounded-box">
            <li>
                <a href="/" @class([
                    'active' => $path == '',
                ])>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
            </li>

            <li>
                <a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Laporan
                </a>
            </li>

            <li>
                <a href="/setting" @class([
                    'active' => $path == 'setting',
                ])>Pengaturan</a>
            </li>
        </ul>
    </div>

    @yield('main')

</body>

</html>
