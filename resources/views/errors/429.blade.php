<x-layout bodyClass="bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        {{-- Sin navbar --}}
    </div>

    <div class="page-header justify-content-center min-vh-100 d-flex align-items-center"
        style="background-color: #1a1a1a;"> <!-- Fondo gris oscuro -->

        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title text-white">429</h1>
                    <h2 class="text-white">Demasiadas solicitudes</h2>
                    <p class="text-white">Ooooups! Has enviado demasiadas peticiones en poco tiempo.</p>
                    <h6 class="text-white">Por favor espera un momento antes de intentarlo de nuevo.</h6>

                    <a href="{{ route('login') }}" class="btn btn-primary mt-4">
                        Iniciar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
