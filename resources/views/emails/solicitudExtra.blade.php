<!DOCTYPE html>
<html>
<head>
    <title>Spectra - OTIS</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p><table border='1'><thead> 
                  <th>PROYECTO</th>
                  <th>TRABAJADOR</th>
                  <th>MOTIVO</th>
                  <th>FECHA</th>
                  <th>HORARIO HABITUAL</th>
                  <th>HORA INICIO EXTRA</th>
                  <th>HORA FIN EXTRA</th>
                  <th>TOTAL HORAS</th>
                  <th>AUTORIZA/RECHAZA</th>
                  <th>SOLICITADA POR</th>
                  <th>FECHA SOLICITUD</th>
                  <th>FECHA AUTORIZACION/RECHAZO</th>
                  <th>OBSERVACIONES</th>
              </thead>
              <tbody>
            
                <tr>
                  <td>{{ $e->proyecto }}</td>
                  <td>{{ $e->nombres }}</td>
                  <td>{{ $e->motivo }}</td>
                  <td>{{ $e->fecha }}</td>
                  <td>{{ $e->horario_habitual }}</td>
                  <td>{{ $e->hora_inicio_extra }}</td>
                  <td>{{ $e->hora_fin_extra }}</td>
                  <td>{{ $e->total_horas }}</td>
                  <td>{{ $e->ndirector->nombre." ".$e->ndirector->apellido1 }}</td>
                  <td>{{ $e->nsolicita->nombre." ".$e->nsolicita->apellido1 }}</td>
                  <td>{{ $e->fecha_solicitud }}</td>
                  <td>{{ $e->fecha_autorizacion_rechazo }}</td>
                  <td>{{ $e->observaciones }}</td>         
                </tr>
             
              </tbody>
          </table></p>
    <p>Ingresar a <a href='http://www.spectraoperaciones.com'>spectraoperaciones.com</a> para realizar la autorización</p>
   
    <p>Gracias!!</p>
</body>
</html>