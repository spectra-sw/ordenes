@extends('layouts.authLayout')

@section('content')
    <form id="submitEmailRecovery">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <img src="{{ URL::asset('img/logo.png') }}">
            <h4 class="text-end">
                <strong>
                    Actualizar contraseña
                </strong>
            </h4>
        </div>

        <!-- Email input -->
        <div class="form-group mb-3">
            <label for="password1" class="form-label fs-6">Nueva contraseña</label>
            <input class="form-control form-control-lg" type="password" id="password1"
                placeholder="Ingresa nueva contraseña" />
        </div>

        <!-- Email input -->
        <div class="form-group mb-1">
            <label for="password2" class="form-label fs-6">Verificación de contraseña</label>
            <input class="form-control form-control-lg" type="password" id="password2"
                placeholder="Ingresa nueva contraseña" />
        </div>

        <div id="mensaje" class="mt-3"></div>

        <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Cambiar contraseña
            </button>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/views/auth/passwordUpdate.js') }}"></script>
@endsection
