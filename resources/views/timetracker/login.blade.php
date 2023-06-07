<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Spectra - Time Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/style_tt.css') }}">
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ URL::asset('img/fondos/foto1.png') }}" class="img-fluid rounded-circle"
                        alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form id="submitLogin">
                        <div
                            class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mb-4">
                            <img src="{{ URL::asset('img/logo.png') }}">
                        </div>

                        <!-- Email input -->
                        <div class="form-group mb-3">
                            <label for="email" class="form-label fs-6">Correo electrónico</label>
                            <input class="form-control form-control-lg" type="email" id="email" placeholder="Ingresa correo electrónico" />
                        </div>


                        <!-- Password input -->
                        <div class="form-group">
                            <label for="pwd" class="form-label fs-6">Contraseña</label>
                            <input class="form-control form-control-lg" type="password" id="pwd" placeholder="Ingresa contraseña" />
                        </div>


                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Ingresar
                            </button>
                        </div>
                        <div id="mensaje" class="mt-2"></div>
                    </form>
                </div>
            </div>
        </div>
        <a href="https://wa.me/573165265937"><img src="{{ URL::asset('img/whatsapp.png') }}" class="helpIcon"></a>
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-1"
            style="margin-top: 7px;">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2023. All rights reserved.
            </div>
            <!-- Copyright -->

            <!-- Right -->
            <!-- <div>
        <a href="#!" class="text-white me-4">
          <i class="fab fa-facebook-f">sfsfs</i>
        </a>
      </div> -->
            <!-- Right -->
        </div>

    </section>
</body>
<script src="{{ asset('js/scripts.js') }}"></script>
