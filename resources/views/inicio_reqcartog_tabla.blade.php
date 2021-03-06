<thead>
										  <tr>
										  	<th>N</th>
											<th>Cantidad</th>
											<th>Descripción</th>
											<th>Fecha de devolución</th>
											<th>Observación</th>
											<th>Consultar</th>
											<th>Eliminar</th>
										  </tr>
										</thead>
										<?php $i=1;?>
@foreach($resultado as $row)

											
											  <tr>
											  	<td>{{$i}}</td>
												<td>{{$row->cantidad}}</td>
												<td>{{$row->equipo->nombre}}</td>
												<?php  
		                                            $date=date_create($row->fecha_devolucion);
		                                            $freu=$date->format('d-m-Y');
		                                            ?>
												<td>{{$freu}}</td>
												<td>{{$row->observaciones}}</td>
											
												<td><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="ConsultarEquipCartografia({{$row->idreqcartodeta}})"></i></a></td>
												<td><a href="#"><i class="fa fa-trash" onclick="EliminarEquipCartografia({{$row->idreqcartodeta}})"></i></a></td>
											  </tr>
											  
											<?php $i++;?>
										@endforeach