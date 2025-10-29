<section class="hero min-h-screen w-8/12">
    <div class="hero-content flex-col lg:flex-row-reverse">
        <div class="text-center lg:text-left">
            <h1 class="text-5xl font-bold">Login now!</h1>
            <p class="py-6">
                Keuangan yang sehat dimulai dari pencatatan yang disiplin. Ambil langkah pertama sekarang!
            </p>

            <a href="/register/modern-art" class="btn btn-sm btn-link no-underline">Sudah punya akun.</a>

        </div>
        <div class="card bg-white w-full max-w-sm shrink-0 shadow-2xl">
            <div class="card-body">
                <fieldset class="fieldset">

                    <label class="label">Email</label>
                    <input type="email" wire:model="email" class="input" placeholder="Email" autocomplete="off"
                        wire:keyup.enter="doLogin" />
                    @error('email')
                        <p class="text-red-500 italic">{{ $message }}</p>
                    @enderror

                    <label class="label">Password</label>
                    <input type="password" wire:model="password" class="input" placeholder="Password"
                        wire:keyup.enter="doLogin" />
                    @error('password')
                        <p class="text-red-500 italic">{{ $message }}</p>
                    @enderror

                    <button wire:click="doLogin" class="btn btn-primary btn-sm mt-4">Login</button>
                </fieldset>
            </div>
        </div>
    </div>

    <script src="/sweetalert/sweetalert.js"></script>
    <script>
        window.addEventListener('show-login-success', event => {
            Swal.fire({
                title: 'Berhasil',
                text: "Berhasil",
                icon: 'success',
                didClose: () => {
                    Livewire.dispatch('redirect-to-dashboard')
                }
            })
        })

        window.addEventListener('show-login-failed', event => {
            Swal.fire({
                title: 'Gagal',
                text: "Email / Password salah.",
                icon: 'error'
            })
        })
    </script>

</section>
