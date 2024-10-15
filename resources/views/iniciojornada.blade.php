@extends('layouts.tt')

@section('content')
    <div class="row">
        <div class="col-12">
            <div id="formJornada" style="display: block">
                <form id="formRegistro" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="jornada_id" name="jornada_id">
                    <div class="card">
                        <div class="card-header">Registro jornada de trabajo</div>
                        <div class="card-body">
                            <input type="hidden" id="tipo" name="tipo" value="1">
                            
                            <div id="datos">
                                <div class="row">
                                    <div class="col-6 col-md-2 cajaAzul">Proyecto *</div>
                                    <div class="col-6 col-md-2 ">
                                        <select class="form-control" name="proyecto" id="proyecto"
                                            onchange="buscarP(this.value)" required>
                                            <option value=""></option>
                                            <option value="7">7</option>
                                            @foreach ($proyectos as $p)
                                                <option value="{{ $p->proyecto }}">{{ $p->proyecto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-2 cajaAzul">Subportafolio</div>
                                    <div class="col-6 col-md-2 "><input type="text" name="subportafolio"
                                            id="subportafolio" class="form-control" disabled></div>
                                </div>

                                <div class="row">
                                    <div class="col-6 col-md-2 cajaAzul">Descripción</div>
                                    <div class="col-6 col-md-4 "><input type="text" name="descripcion"
                                            id="descripcion" class="form-control" disabled></div>
                                    <div class="col-6 col-md-1 cajaAzul">Director</div>
                                    <div class="col-6 col-md-2 "><input type="text" name="director" id="director"
                                            class="form-control" disabled></div>
                                    <div class="col-6 col-md-1 cajaAzul">Líder</div>
                                    <div class="col-6 col-md-2 "><input type="text" name="lider" id="lider"
                                            class="form-control" disabled></div>
                                </div>

                                <div class="row">
                                    <div class="col-6 col-md-2 cajaAzul">Cliente</div>
                                    <div class="col-6 col-md-2 "><input type="text" name="cliente" id="cliente"
                                            class="form-control" disabled></div>
                                    <div class="col-6 col-md-2 cajaAzul">Contacto</div>
                                    <div class="col-6 col-md-2 "><input type="text" name="contacto" id="contacto"
                                            class="form-control" disabled></div>
                                </div>

                                <br>
                                <!-- Mapa pequeño y coordenadas -->
                                <div class="row">
                                    <div class="col-6 col-md-2 cajaAzul">Coordenadas:</div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitud" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitud" readonly>
                                    </div>
                                </div>
                                <br>
                                <div id="map" style="height: 300px;"></div>
                                <br>
                            </div>

                            <div id="datos2">
                                <!-- Fecha y hora actual -->
                                <div class="row">
                                    <div class="col-6 col-md-2 cajaAzul">Fecha actual</div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" name="fechaActual" id="fechaActual" class="form-control" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 cajaAzul">Hora actual</div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" name="horaActual" id="horaActual" class="form-control" readonly>
                                    </div>
                                </div>
                                <br>

                                <!-- Habilitar la cámara para capturar imagen -->
                                <div class="row">
                                    <div class="col-12">
                                        <label for="imagenes">Capturar imagen (*no obligatorio)</label>
                                        <input type="file" name="imagenes[]" id="imagenes" class="form-control" accept="image/*" capture="camera" multiple>
                                        <br>
                                        <img id="previewImg" src="#" alt="Imagen previa" style="display: none; max-width: 300px;"/>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-success" id="btnRegistrar" type="button">Registrar</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div id="mensaje"></div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        // Obtener coordenadas geográficas
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;

                // Mostrar las coordenadas en los inputs
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lon;

                // Inicializar el mapa
                var map = L.map('map').setView([lat, lon], 13);

                // Cargar y mostrar el mapa
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                // Añadir un marcador en la ubicación actual
                L.marker([lat, lon]).addTo(map)
                    .bindPopup('Tu ubicación actual.')
                    .openPopup();
            });
        } else {
            alert("Geolocalización no soportada en este navegador.");
        }

        // Mostrar fecha y hora actual
        function actualizarFechaHora() {
            var now = new Date();
            var fecha = now.toLocaleDateString();
            var hora = now.toLocaleTimeString();

            document.getElementById('fechaActual').value = fecha;
            document.getElementById('horaActual').value = hora;
        }

        setInterval(actualizarFechaHora, 1000);

        // Previsualizar imagen capturada
        document.getElementById('imagenes').onchange = function(evt) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('previewImg').style.display = 'block';
            };
            reader.readAsDataURL(evt.target.files[0]);
        };
    </script>
    <script src="{{ asset('js/scripts_jornadav1.1.js') }}"></script>
@endsection