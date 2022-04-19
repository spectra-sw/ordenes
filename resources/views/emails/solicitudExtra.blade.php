<!DOCTYPE html>
<html>
<head>
    <title>Spectra - OTIS</title>
</head>
<body>
    <h1>{{ $details['title'] }}</h1>
    <p><table border='1'><thead> 
                <tr>
                  <th>PROYECTO</th>
                  <th>TRABAJADOR</th>
                  <th>MOTIVO</th>
                  <th>FECHA</th>
                  <th>HORARIO HABITUAL</th>
                  <th>HORA ENTRADA</th>
                  <th>HORA AUTORIZADA</th>
                  <th>DIRECTOR</th>
                  <th>AUTORIZADA POR</th>
                  <th>FECHA AUTORIZACION</th>
                  <th>FECHA VOBO DIRECTOR</th>
                  <th>OBSERVACIONES</th>
                </tr>
              </thead>
              <tbody>
            
                <tr>
                  <td>{{ $e->proyecto }}</td>
                  <td>{{ $e->ntrabajador->nombre.' '.$e->ntrabajador->apellido1 }}</td>
                  <td>{{ $e->motivo }}</td>
                  <td>{{ $e->fecha }}</td>
                  <td>{{ $e->horario_habitual }}</td>
                  <td>{{ $e->hora_entrada }}</td>
                  <td>{{ $e->hora_autorizada_salida }}</td>
                  <td>{{ $e->ndirector->nombre." ".$e->ndirector->apellido1 }}</td>
                  <td>{{ $e->nautorizado->nombre." ".$e->nautorizado->apellido1 }}</td>
                  <td>{{ $e->fecha_autorizacion }}</td>
                  <td>{{ $e->fecha_vobo_director }}</td>
                 
                </tr>
             
              </tbody>
          </table></p>
    <p>Ingresar a <a href='http://www.spectraoperaciones.com'>spectraoperaciones.com</a> para realizar la autorización</p>
   
    <p>Gracias!!</p>
</body>
</html>