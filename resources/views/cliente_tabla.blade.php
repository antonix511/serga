<table id="myTable" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Nº</th>
      <th>Nombre</th>
      <th>Contacto</th>
      <th>Correo</th>
      <th>Telefono</th>
      <th>Opsiones</th>
    </tr>
  </thead>
  <tbody>
  <?php	$i=1; ?>
  @foreach ($clientes as $cliente)
    <tr>
      <td>{{$i}}</td>
      <td>{{$cliente->persona->nombre}}</td>
      <td>{{$cliente->contacto}}</td>
      <td>{{$cliente->persona->correo}}</td>
      <td>{{$cliente->persona->telefono}} </td>
      <td><div class="opciones"><a class="fa fa-pencil-square-o" onclick="traer_Datos_clientes('{{$cliente->idcliente}}')" ></a></div>
      <div class="opciones"><a class="fa fa-trash" onclick="eliminar_Datos_clientes('{{$cliente->persona->idpersona}}')" ></a></div></td>
  </tr>
  <?php	$i++; ?>
  @endforeach
  </tbody>
</table>
