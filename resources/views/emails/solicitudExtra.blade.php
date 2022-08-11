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
                  <th>HORA ENTRADA</th>
                  <th>HORA AUTORIZADA</th>
                  <th>AUTORIZA/RECHAZA</th>
                  <th>SOLICITADA POR</th>
                  <th>FECHA SOLICITUD</th>
                
                
              </thead>
              <tbody>
            
                <tr>
                  <td>{{ $e->proyecto }}</td>
                  <td>{{ $e->ntrabajador->nombre." ".$e->ntrabajador->apellido1 }}</td>
                  <td>{{ $e->motivo }}</td>
                  <td>{{ $e->fecha }}</td>
                  <td>{{ $e->horario_habitual }}</td>
                  <td>{{ $e->hora_entrada }}</td>
                  <td>{{ $e->hora_autorizada_salida }}</td>
                  <td>{{ $e->ndirector->nombre." ".$e->ndirector->apellido1 }}</td>
                  <td>{{ $e->nsolicita->nombre." ".$e->nsolicita->apellido1 }}</td>
                  <td>{{ $e->fecha_solicitud }}</td>
                
                          
                </tr>
             
              </tbody>
          </table></p>
    <p>Ingresar a <a href='http://www.spectraoperaciones.com'>spectraoperaciones.com</a> para realizar la autorización</p>
   
    <p>Gracias!!</p>
</body>
</html>