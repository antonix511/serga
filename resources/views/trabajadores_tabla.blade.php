<table id="tabletrabajadores" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Nº</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Correo</th>
      <th>Telefono</th>
      <th>Area</th>
      <th>Puesto</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
  <?php	$i=1; ?>
  @foreach ($trabajadores as $trabajador)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$trabajador->persona->nombre}}</td>
                  <td>{{$trabajador->apellidos}}</td>
                  <td>{{$trabajador->persona->correo}}</td>
                  <td>{{$trabajador->persona->telefono}}</td>
                  <td>{{$trabajador->area->nombre}}</td>
                  <td>{{$trabajador->puesto->nombre}}</td>
                  <td><div class="opciones"><a class="fa fa-pencil-square-o" onclick="traer_Datos_trabajador('{{$trabajador->idpersona}}')" ></a></div>
                  <div class="opciones"><a class="fa fa-trash" onclick="eliminar_Datos_trabajador('{{$trabajador->idpersona}}')"></a></div>
                </td>
              </tr>
              <?php $i++; ?>
              @endforeach
  </tbody>
</table>
