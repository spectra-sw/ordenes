<!DOCTYPE html>
<html lang="en">

<head>
    <title>Spectra - Time Tracker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/style_tt.css') }}">
</head>

<body class="random-background-image bg-light">

    <!-- Navbar -->
    @include('components.surfaces.navbar')

    <main class="container-fluid py-4">
        @yield('content')
        <a href="https://wa.me/573165265937" target="_blank"><img src="{{ URL::asset('img/whatsapp.png') }}"
                class="helpIcon"></a>

        <!-- Modals -->
        <div class="modal" tabindex="-1" id="modalFeedback">
            <div class="modal-dialog">
                <div class="modal-content" id="modalFeedbackContent">

                </div>
            </div>
        </div>

    </main>

    {{-- dinamic scripts --}}
    @yield('scripts')

</body>

</html>
