<x-guest-layout>
    <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
        <div class="col-sm-8 col-md-6 col-xl-9">
            
            <div class="text-center">
                <h2 class="mb-3 fs-7 fw-bolder">INICIAR SESIÓN</h2>
            </div>
            <p class="mb-9">Bienvenido a CEPRE UNH 👋 </p>
           
            {{-- <div class="position-relative text-center my-4">
                <p class="mb-0 fs-4 px-3 d-inline-block text-bg-white text-dark z-index-5 position-relative"> INTRANET 2024 </p>
                <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
            </div> --}}

            <x-auth-session-status class="my-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label class="form-label" for="email" :value="__('Correo')" />
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <x-input-label class="form-label" for="password" :value="__('Contraseña')" />

                    <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Remember Me -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label class="form-check-label" for="remember_me">
                            {{ __('Recordar contraseña') }}
                        </label>
                    </div>

                    
                </div>

                <div class="d-flex justify-content-end my-4">
                    
                    <x-primary-button class="btn btn-primary w-100">
                        {{ __('INGRESAR AL INTRANET') }}
                    </x-primary-button>
                </div>
                
                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="text-primary fw-medium me-3" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
