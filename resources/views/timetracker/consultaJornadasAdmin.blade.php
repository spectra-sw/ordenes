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
                            <th>Ref. Horario</th>
                            <th>Novedades</th>
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
                            <tr @if($j->es_festivo) class="table-danger" @elseif($j->es_domingo) class="table-secondary" @endif>
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

                                {{-- Ref. Horario --}}
                                <td style="white-space:nowrap; font-size:12px;">
                                    <span class="badge {{ $j->horario_label === 'T' ? 'bg-info' : 'bg-secondary' }}"
                                          title="{{ $j->horario_nombre }}">
                                        {{ $j->horario_label }}
                                    </span>
                                    {{ $j->horario_rango }}
                                    <br><small class="text-muted">{{ $j->laborales_ref }}h lab.</small>
                                </td>

                                {{-- Novedades --}}
                                <td style="white-space:nowrap;">
                                    @if($j->tiene_extra)
                                        @foreach($j->tipo_extra as $te)
                                            <span class="badge bg-warning text-dark">{{ $te }}</span>
                                        @endforeach
                                    @endif
                                    @if($j->tiene_recargo)
                                        <span class="badge bg-primary">Rec.Noc</span>
                                    @endif
                                    @if(!$j->tiene_extra && !$j->tiene_recargo)
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

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
    window.map = false;
    function openMapModal(jornadaId) {
    // Abre el modal
    $('#mapModal').modal('show');

    var imagesDiv = document.getElementById('images');
    imagesDiv.innerHTML = ''; 

    // Check if the map exists
    if (window.map) {
        // Clear all layers before resetting the view
        window.map.eachLayer(function(layer) {
            window.map.removeLayer(layer);
        });

        // Optionally reset the view (you can choose a different default position)
        window.map.setView([0, 0], 13);  // Set to some default location
    } else {
        // Initialize the map if it doesn't exist
        window.map = L.map('map').setView([0, 0], 13);  // You can change the initial coordinates here

        // Add tile layer (you need to do this only once)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(window.map);
    }

    // Cargar las evidencias para la jornada
    fetch(`/api/evidencias/${jornadaId}`)
        .then(response => response.json())
        .then(data => {
            // Actualizar la vista y los marcadores con la información de la jornada
            if (data && data.length > 0) {
                // Re-set map view to the first evidencia's latitud/longitud
                window.map.setView([data[0].latitud, data[0].longitud], 13);

                // Iterar sobre las evidencias (inicio y fin)
                data.forEach(evidencia => {
                    var marker = L.marker([evidencia.latitud, evidencia.longitud]).addTo(window.map);
                    marker.bindPopup("Ubicación de jornada");

                    // Mostrar las imágenes asociadas
                    var img = document.createElement('img');
                    img.src = evidencia.url_imagen;
                    img.style.width = '100px';

                    // Crear un contenedor para la imagen y la fecha
                    var imgContainer = document.createElement('div');
                    imgContainer.style.marginBottom = '10px'; // Para separar las imágenes

                    // Agregar la imagen al contenedor
                    imgContainer.appendChild(img);

                    // Agregar la fecha de creación debajo de la imagen
                    var createdAt = document.createElement('p');
                    createdAt.style.fontSize = '12px';
                    createdAt.style.color = '#555';
                    createdAt.innerHTML = `Creada: ${new Date(evidencia.created_at).toLocaleString()}`;

                    // Agregar el texto de la fecha al contenedor
                    imgContainer.appendChild(createdAt);

                    // Agregar el contenedor de imagen y fecha al div de imágenes
                    imagesDiv.appendChild(imgContainer);
                });
            }
        })
        .catch(error => {
            console.error("Error al cargar las evidencias:", error);
        });
}

</script>
