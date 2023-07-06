@extends('layouts.authLayout')

@section('content')
    <form id="submitLogin" novalidate>
        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mb-4">
            <img src="{{ URL::asset('img/logo.png') }}">
        </div>

        <!-- Email input -->
        <div class="form-group mb-3">
            <label for="email" class="form-label fs-6">Correo electrónico</label>
            <input class="form-control form-control-lg" type="email" id="email"
                placeholder="Ingresa correo electrónico" />
        </div>


        <!-- Password input -->
        <div class="form-group mb-2">
            <label for="pwd" class="form-label fs-6">Contraseña</label>
            <input class="form-control form-control-lg" type="password" id="pwd" placeholder="Ingresa contraseña" />
        </div>

        <a href="{{route("v2.page.password.recovery")}}">¿Olvidaste tu contraseña?</a>

        <div id="mensaje" class="mt-3"></div>

        <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Ingresar
            </button>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/views/auth/login.js') }}"></script>
@endsection
