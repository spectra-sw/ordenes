@extends('layouts.authLayout')

@section('content')
    <form id="submitEmailRecovery">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <img src="{{ URL::asset('img/logo.png') }}">
            <h4 class="text-end">
                <strong>
                    ¿Olvidaste tu contraseña?
                </strong>
            </h4>
        </div>

        <!-- Email input -->
        <div class="form-group mb-1">
            <label for="email" class="form-label fs-6">Email de recuperación</label>
            <input class="form-control form-control-lg" type="email" id="email"
                placeholder="Ingresa correo electrónico" />
        </div>
        <a href="{{ route('inicio') }}">
            <i class="bi bi-arrow-bar-left mr-2"></i>
            atras
        </a>

        <div id="mensaje" class="mt-3"></div>

        <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Enviar correo
            </button>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/views/auth/passwordRecovery.js') }}"></script>
@endsection
