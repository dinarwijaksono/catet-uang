<section class="flex justify-center pt-10">
    <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
        <div class="card-header py-2 px-4">
            <h1 class="text-4xl text-center mb-4">Register</h1>

            @error('general')
                <div class="alert alert-error">{{ $message }}</div>
            @enderror

        </div>

        <div class="card-body">
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Name</span>
                </label>
                <input type="text" wire:model="name" placeholder="name" class="input input-bordered mb-2" />

                @error('name')
                    <p class="text-error text-sm italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" wire:model="email" placeholder="email" class="input input-bordered mb-2"
                    required />

                @error('email')
                    <p class="text-error text-sm italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="password" wire:model="password" placeholder="password" class="input input-bordered"
                    required />

                @error('password')
                    <p class="text-error text-sm italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Konfirmasi Password</span>
                </label>
                <input type="password" wire:model="confirmation_password" placeholder="password"
                    class="input input-bordered" required />

                @error('confirmation_password')
                    <p class="text-error text-sm italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-control mt-6">
                <button type="button" wire:click="save" class="btn btn-primary">
                    <span wire:loading.class="hidden">Daftar</span>

                    <span wire:loading class="loading loading-dots loading-md"></span>
                </button>


            </div>
        </div>

        <div class="card-footer p-4 text-center">
            <a href="/login" class="link link-info">Sudah punya akun.</a>
        </div>
    </div>
</section>
