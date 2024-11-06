<div class="card">
    <div class="card-header">Rango de fechas</div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 overflow-auto" style="height: 80vh">
                <p>Total jornadas: {{ $total_jornadas }}</p>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Proyecto</th>
                            <th>Cliente</th>
                            <th>Fecha Inicio</th>
                            <th>Hora Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Hora Fin</th>
                            <th>Duración</th>
                            <th>Almuerzo</th>
                            <th>Laborales</th>
                            <th>Creación</th>
                            <th>Evidencias</th>
                            <th>Aprobación</th>
                            <th>Aprobada por</th>
                            <th>Observaciones</th>
                            <th>Actualización</th>
                            @if (session('tipo') == 0)
                                <th>Acción</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jornadas as $j)
                            <?php $duracion = intval(explode(':', $j->duracion)[0]) + round(floatval(explode(':', $j->duracion)[1] / 60), 2); ?>
                            <tr>
                                <td>
                                    {{ $j->trabajador->apellido1 . ' ' . $j->trabajador->apellido2 . ' ' . $j->trabajador->nombre }}
                                </td>

                                <td>{{ $j->proyecto }}</td>
                                <td>{{ $j->proyectoinfo->cliente->cliente ?? 'N/A' }}</td>
                                <td>{{ $j->fecha }}</td>
                                <td>
                                    @if (session('tipo') == 0 && $j->corte_status == 1)
                                        <input style="font-size: 14px; width: 64px;" class="form-control" type="text"
                                            id="hi{{ $j->id }}" name="hi{{ $j->id }}"
                                            value="{{ $j->hi }}">
                                    @else
                                        {{ $j->hi }}
                                    @endif
                                </td>
                                <td>{{ $j->fechaf }}</td>
                                <td>
                                    @if (session('tipo') == 0 && $j->corte_status == 1)
                                        <input style="font-size: 14px; width: 64px;" class="form-control" type="text"
                                            id="hf{{ $j->id }}" name="hf{{ $j->id }}"
                                            value="{{ $j->hf }}">
                                    @else
                                        {{ $j->hf }}
                                    @endif
                                </td>
                                <td>
                                    <input style="font-size: 14px; width: 60px;" class="form-control" type="text"
                                        id="duracion{{ $j->id }}" name="duracion{{ $j->id }}"
                                        value="{{ $duracion }}" disabled>
                                </td>

                                <td>
                                    @if (session('tipo') == 0 && $j->corte_status == 1)
                                        <input style="font-size: 14px; width: 64px;" class="form-control" type="number"
                                            min="0" id="almuerzo{{ $j->id }}"
                                            name="almuerzo{{ $j->id }}" value="{{ $j->almuerzo }}">
                                    @else
                                        {{ $j->almuerzo }}
                                    @endif
                                </td>

                                <td>{{ $duracion - $j->almuerzo }}</td>
                                <td>{{ $j->created_at }}</td>
                                <!-- Aquí agregamos las evidencias -->
                                <td>
                                    @if ($j->evidencias->count() > 0)
                                        <a href="#" onclick="openMapModal({{ $j->id }})">Ver Mapa</a>
                                    @else
                                        No hay evidencias
                                    @endif
                                </td>
                                @switch($j->estado)
                                    @case(1)
                                        <td class="table-warning">Pendiente</td>
                                    @break

                                    @case(2)
                                        <td class="table-success">Aprobada</td>
                                    @break

                                    @case(3)
                                        <td class="table-danger">Rechazada</td>
                                    @break

                                    @default
                                        Valor no reconocido
                                @endswitch
                                @if  ($j->revisado_por >0)
                                    <td>{{ $j->revisado->nombre . " " .$j->revisado->apellido1 }}</td> 
                                @else
                                    <td></td>
                                @endif 
                               
                                <td style="width: 100px">
                                    @if (session('tipo') == 0 && $j->corte_status == 1)
                                        <input style="font-size: 14px; width: 100px;" class="form-control"
                                            type="text" id="obs{{ $j->id }}" name="obs{{ $j->id }}"
                                            value="{{ str_replace(' ', ' ', $j->observacion) }}">
                                    @else
                                        {{ $j->observacion }}
                                    @endif
                                </td>

                                <td>{{ $j->fecha_revision }}</td>

                                <td>
                                    @if (session('tipo') == 0 && $j->corte_status == 1)
                                        <select class="form-control" onchange="accionj(this.value,this.id)"
                                            id="{{ $j->id }}">
                                            <option value="0">--Elige una opción--</option>
                                            <option value="1">Aprobar</option>
                                            <option value="2">Rechazar</option>
                                        </select>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div>
<!-- Modal para mostrar el mapa -->
<div id="mapModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubicación de la jornada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 400px; width: 100%;"></div>
                <div id="images"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- El código JavaScript debe ir después de la tabla y el modal -->
<!-- Incluye jQuery y Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <!-- Leaflet CSS -->
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
 <!-- Leaflet JS -->
 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    function openMapModal(jornadaId) {
        // Abre el modal
        $('#mapModal').modal('show');

        // Cargar las evidencias para la jornada
        fetch(`/api/evidencias/${jornadaId}`)
            .then(response => response.json())
            .then(data => {
                // Inicializar el mapa
                console.log(data);
                var map = L.map('map').setView([data[0].latitud, data[0].longitud], 13);

                // Cargar capa de mapa
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Limpiar el contenedor de imágenes
                var imagesDiv = document.getElementById('images');
                imagesDiv.innerHTML = ''; 

                // Iterar sobre las evidencias (inicio y fin)
                data.forEach(evidencia => {
                    // Agregar marcador para cada ubicación
                    console.log(evidencia);
                    var marker = L.marker([evidencia.latitud, evidencia.longitud]).addTo(map);
                    marker.bindPopup("Ubicación de jornada");

                    // Mostrar las imágenes asociadas
                    var img = document.createElement('img');
                    img.src = evidencia.url_imagen;
                    img.style.width = '100px';
                    imagesDiv.appendChild(img);
                });
            });
    }
</script>
