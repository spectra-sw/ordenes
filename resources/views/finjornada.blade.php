@extends('layouts.tt')

@section('content')
    <div class="row">
        <div class="col-12">
            <div id="formJornada" style="display: block">
                <form id="formRegistro" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="jornada_id" name="jornada_id" value="{{ $jornada->id }}">
                    <div class="card">
                        <div class="card-header">Finalizar jornada de trabajo</div>
                        <div class="card-body">
                            <input type="hidden" id="tipo" name="tipo" value="1">
                            
                            <div id="datos">
                                <div class="row">
                                    <div class="col-6 col-md-2 cajaAzul">Proyecto *</div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" class="form-control" name="proyecto" id="proyecto"
                                            value="{{ $jornada->proyecto }}" disabled>
                                    </div>
                                    <div class="col-6 col-md-2 cajaAzul">Subportafolio</div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" name="subportafolio" id="subportafolio" 
                                            class="form-control" value="{{ $jornada->subportafolio }}" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 col-md-2 cajaAzul">Descripción</div>
                                    <div class="col-6 col-md-4 ">
                                        <input type="text" name="descripcion" id="descripcion" 
                                            class="form-control" value="{{ $jornada->descripcion }}" disabled>
                                    </div>
                                    <div class="col-6 col-md-1 cajaAzul">Director</div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" name="director" id="director" 
                                            class="form-control" value="{{ $jornada->director }}" disabled>
                                    </div>
                                    <div class="col-6 col-md-1 cajaAzul">Líder</div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" name="lider" id="lider" 
                                            class="form-control" value="{{ $jornada->lider }}" disabled>
                                    </div>
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
                                        <input type="text" name="fechaf" id="fechaf" class="form-control" readonly>
                                    </div>
                                    <div class="col-6 col-md-2 cajaAzul">Hora actual</div>
                                    <div class="col-6 col-md-2 ">
                                        <input type="text" name="hf" id="hf" class="form-control" readonly>
                                    </div>
                                </div>
                                <br>

                                <!-- Habilitar la cámara para capturar imagen -->
                                <div class="row">
                                    <div class="col-12">
                                        <label for="imagenes">Capturar imagen</label>
                                        <input type="file" name="imagenes[]" id="imagenes" class="form-control" accept="image/*" capture="camera" multiple >
                                        <br>
                                        <img id="previewImg" src="#" alt="Imagen previa" style="display: none; max-width: 300px;"/>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-success" id="btnRegistrarFin" type="button">Registrar finalización</button>
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
            var fecha = now.getFullYear() + '-' + 
            String(now.getMonth() + 1).padStart(2, '0') + '-' + 
            String(now.getDate()).padStart(2, '0');
            var hora = now.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });

            document.getElementById('fechaf').value = fecha;
            document.getElementById('hf').value = hora;
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
    <script src="{{ vasset('js/scripts_jornadav11.js') }}"></script>
@endsection