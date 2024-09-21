<x-guest-layout>
    <div class="card mb-0 shadow-none rounded-0 min-vh-100 h-100">
        <div class="d-flex align-items-center w-100 h-100">
          <div class="card-body">
            <div class="mb-5">
                <h2 class="fw-bolder fs-7 mb-3">{{ __('¿Olvidaste tu contraseña?') }}</h2>
                <p class="mb-0 ">   
                    {{ __('Ingrese la dirección de correo electrónico asociada a su cuenta y le enviaremos un enlace para restablecer su contraseña.') }}                                
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
        
                <!-- Email Address -->
                <div>
                    <x-input-label class="form-label" for="email" :value="__('Correo electrónico')" />
                    <x-text-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="w-100 py-8 mb-3">{{ __('ENVIAR CORREO DE RECUPERACIÓN') }}</x-primary-button>
                    <a href="{{ route('login') }}" class="btn bg-info-subtle w-100 py-8">{{ __('REGRESAR') }}</a>
                </div>
            </form>
          </div>
        </div>
      </div>
</x-guest-layout>
