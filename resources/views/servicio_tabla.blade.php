<table id="tableservicios" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Nº</th>
      <th>Nombre</th>
      <th>Abreiatura</th>
      <th>Opciones</th>
    </tr>
  </thead>
  <tbody>
  <?php	$i=1; ?>
  @foreach ($servicios as $servicio)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$servicio->nombre}}</td>
                  <td>{{$servicio->abreviatura}}</td>
                  <td>

                  <div class="opciones">
                  <a class="fa fa-pencil-square-o" onclick="traer_Datos_servicio('{{$servicio->idservicio}}')" ></a>
                  </div>

                  <div class="opciones">
                  <a class="fa fa-trash" onclick="eliminar_Datos_servicio('{{$servicio->idservicio}}')"></a>
                  </div>

                  </td>
              </tr>
              <?php $i++; ?>
              @endforeach
  </tbody>
</table>
