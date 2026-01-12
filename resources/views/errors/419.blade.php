<x-layout bodyClass="bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        {{-- Sin navbar --}}
    </div>

    <div class="page-header justify-content-center min-vh-100 d-flex align-items-center"
        style="background-color: #1a1a1a;"> <!-- Fondo gris oscuro -->

        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title text-white">419</h1>
                    <h2 class="text-white">Sesión expirada</h2>
                    <p class="text-white">Ooooups! Parece que tu sesión ha expirado o el token ha caducado.</p>
                    <h6 class="text-white">Por favor, vuelve a intentarlo o inicia sesión nuevamente.</h6>

                    <a href="{{ route('login') }}" class="btn btn-primary mt-4">
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
