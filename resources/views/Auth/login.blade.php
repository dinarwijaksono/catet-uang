<!DOCTYPE html>
<html lang="en" data-theme="business">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="/tailwind/style.css">
</head>

<body>

    <section class="flex justify-center pt-10">
        <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
            <div class="card-header py-2 px-4">
                <h1 class="text-4xl text-center mb-4">LOGIN</h1>

                @error('general')
                    <div class="alert alert-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="card-body">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Email</span>
                    </label>
                    <input type="email" wire:model="email" wire:keydown.enter="login" placeholder="email"
                        class="input input-bordered mb-2" required />

                    @error('email')
                        <p class="text-error text-sm italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" wire:model="password" wire:keydown.enter="login" placeholder="password"
                        class="input input-bordered" required />

                    @error('password')
                        <p class="text-error text-sm italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control mt-6">
                    <button type="button" wire:click="login" class="btn btn-primary">
                        <span wire:loading.class="hidden">Login</span>

                        <span wire:loading class="loading loading-dots loading-md"></span>
                    </button>
                </div>
            </div>

            <div class="card-footer p-4 text-center">
                <a href="/register" class="link link-info">Belum punya akun, buat sekarang.</a>
            </div>
        </div>
    </section>

</body>

</html>
