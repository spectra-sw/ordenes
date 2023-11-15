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

        <div class="modal fade" tabindex="-1" id="notifications">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Notificaciones</h5>
                        <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="font-size: 20px">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="notificationContainer">
                        {{-- <div class="border-primary mb-2 rounded shadow py-2 bg-light card-notification-new"
                            data-id="1"
                            style="border-left: 8px solid; padding-left: 8px">
                            <small><b>12-11-2023</b></small><br>
                            <span>Content de algo por ahi</span>
                        </div> --}}

                        {{-- <div class="d-none border-secondary mb-2 rounded shadow py-2 bg-light card-notification-old"
                            data-id="1"
                            style="border-left: 8px solid; padding-left: 8px">
                            <small><b>12-11-2023</b></small><br>
                            <span>Content de algo por ahi</span>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-notification-new" style="width: 100%">
                            Nuevas Notificaciones
                        </button>
                        <button type="button" class="btn btn-secondary" id="btn-notification-old" style="width: 100%">
                            Ultimas Notificaciones
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    {{-- dinamic scripts --}}
    @yield('scripts')
    <script>
        const test1 = () => $("#notifications").modal("show");
        const containerNotification = document.querySelector(
            "#notificationContainer"
        );

        $("#btn-notification-new").click(() => {
            $("#btn-notification-new").removeClass("btn-secondary").addClass("btn-primary");
            $("#btn-notification-old").removeClass("btn-primary").addClass("btn-secondary");

            $('.card-notification-new').removeClass('d-none');
            $('.card-notification-old').addClass('d-none');
        });

        $("#btn-notification-old").click(() => {
            $("#btn-notification-new").removeClass("btn-primary").addClass("btn-secondary");
            $("#btn-notification-old").removeClass("btn-secondary").addClass("btn-primary");

            $('.card-notification-new').addClass('d-none');
            $('.card-notification-old').removeClass('d-none');
        });

        if (containerNotification !== null) {
            const observerContainerNotification = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting && !containerNotification.classList.contains('notificated')) {
                        const notificationIds = [];
                        containerNotification.classList.add('notificated');
                        document.querySelectorAll(".card-notification-new").forEach((card) => {
                            notificationIds.push(card.dataset.id);
                        });

                        if (notificationIds.length === 0) return;

                        $.ajax({
                            url: "/notificaciones/read",
                            type: "GET",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                notification_ids: notificationIds
                            },
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        })
                    }
                });
            });
            observerContainerNotification.observe(containerNotification);
        }

        document.addEventListener('DOMContentLoaded', async () => {
            $.ajax({
                url: "/notificaciones",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    const newNotifications = response.new_notifications
                    const oldNotifications = response.old_notifications

                    document.querySelectorAll(".notification-count").forEach((count) => {
                        count.innerText = newNotifications.length;
                    });

                    if (newNotifications.length === 0) {
                        containerNotification.classList.add('notificated');
                        const card = `
                            <p class="mb-2 card-notification-new">
                                <b>No hay notificaciones nuevas</b>
                            </p>
                        `
                        $("#notificationContainer").append(card)
                    }

                    newNotifications.forEach(notification => {
                        const date = new Date(notification.created_at)
                        const dateStr =
                            `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`
                        const card = `
                            <div class="border-primary mb-2 rounded shadow py-2 bg-light card-notification-new"
                                data-id="${notification.id}"
                                style="border-left: 8px solid; padding-left: 8px">
                                <small><b>${dateStr}</b></small><br>
                                <span>${notification.content}</span>
                            </div>
                        `
                        $("#notificationContainer").append(card)
                    });

                    oldNotifications.forEach(notification => {
                        const date = new Date(notification.created_at)
                        const dateStr =
                            `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`
                        const card = `
                            <div class="d-none border-primary mb-2 rounded shadow py-2 bg-light card-notification-old"
                                style="border-left: 8px solid; padding-left: 8px">
                                <small><b>${dateStr}</b></small><br>
                                <span>${notification.content}</span>
                            </div>
                        `
                        $("#notificationContainer").append(card)
                    });
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });
    </script>
</body>

</html>
