<x-guest-layout>
    <!-- Mensaje de sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo electrónico -->
        <div>
            <x-input-label for="email" :value="'Correo electrónico'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Contraseña'" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Botón -->
        <div class="flex justify-end mt-6">
            <x-primary-button>
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
