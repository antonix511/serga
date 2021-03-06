<thead>
										  <tr>
											<th>Nº</th>
											<th>Fecha</th>
											<th>Actividad</th>						
											<th>Consultar</th>
											<th>Eliminar</th>
										  </tr>
										</thead>
										<tbody>
										<?php $i=1;?>
										@foreach($resultado as $row)
										  <tr>
											<td>{{$i}}</td>
											<td>{{$row->fecha}}</td>
											<td>{{$row->actividad}}</td>
								
										
											<td><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="ConsultarProgramacionAcuerdo({{$row->idactaacuerdodet}})"></i></a></td>
											<td><a href="#"><i class="fa fa-trash" aria-hidden="true" onclick="EliminarProgramacionAcuerdo({{$row->idactaacuerdodet}})"></i></a></td>
										  </tr>
										  <?php $i++;?>
										  @endforeach