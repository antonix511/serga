<table id="myTable" class="table">
<thead>
										  <tr>
											<th>Área de Logistica y Mantenimiento</th>
											<th>Cantidad</th>
											<th>Unidad</th>
											<th>Descripción</th>
											<th>Personal Asignado</th>
											<th>Consultar</th>
											<th>Eliminar</th>
										  </tr>
										</thead>
@foreach($resultado as $row)

										<tbody>
										  <tr>
											<td>{{@$row->logistica->nombre}}</td>
											<td>{{$row->cantidad}}</td>
											<td>{{@$row->unidad->nombre}}</td>
											<td>{{$row->descripcion}}</td>
											<td>{{@$row->persona->nombre}} {{@$row->trabajador->apellidos}}</td>
											<td><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="ConsultarEquipLogistica({{$row->idreqlogisdeta}})"></i></a></td>
											<td><a href="#"><i class="fa fa-trash" onclick="EliminarEquipLogistica({{$row->idreqlogisdeta}})"></i></a></td>
										  </tr>
										  
										</tbody>
@endforeach
</table>