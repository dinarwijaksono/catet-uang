<section class="hero min-h-screen w-8/12">
    <div class="hero-content flex-col lg:flex-row-reverse">
        <div class="text-center lg:text-left">
            <h1 class="text-5xl font-bold">Register now!</h1>
            <p class="py-6">
                Keuangan yang sehat dimulai dari pencatatan yang disiplin. Ambil langkah pertama sekarang!
            </p>

            <a href="/login/modern-art" class="btn btn-sm btn-link no-underline">Sudah punya akun.</a>

        </div>
        <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
            <div class="card-body">
                <fieldset class="fieldset">
                    <label class="label">Name</label>
                    <input type="text" wire:model="name" class="input" placeholder="name" />
                    @error('name')
                        <p class="text-red-500 italic">{{ $message }}</p>
                    @enderror

                    <label class="label">Email</label>
                    <input type="email" wire:model="email" class="input" placeholder="Email" />
                    @error('email')
                        <p class="text-red-500 italic">{{ $message }}</p>
                    @enderror

                    <label class="label">Password</label>
                    <input type="password" wire:model="password" class="input" placeholder="Password" />
                    @error('password')
                        <p class="text-red-500 italic">{{ $message }}</p>
                    @enderror

                    <label class="label">Konfirmasi password</label>
                    <input type="password" wire:model="confirmation_password" class="input"
                        placeholder="Konfirmasi password" />
                    @error('confirmation_password')
                        <p class="text-red-500 italic">{{ $message }}</p>
                    @enderror

                    <button wire:click="doRegister" class="btn btn-primary btn-sm mt-4">Daftar</button>
                </fieldset>
            </div>
        </div>
    </div>

    <script src="/sweetalert/sweetalert.js"></script>
    <script>
        window.addEventListener('show-register-success', event => {
            Swal.fire({
                title: 'Berhasil',
                text: "Akun berhasil disimpan",
                icon: 'success',
                didClose: () => {
                    Livewire.dispatch('redirect-to-dashboard')
                }
            })
        })

        window.addEventListener('show-register-failed', event => {
            Swal.fire({
                title: 'Gagal',
                text: "Email tidak tersedia.",
                icon: 'error'
            })
        })
    </script>

</section>
