<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="exampleModalLabel">LISTA USUARIOS 
	<br><small><strong>Dependencia: </strong><?php echo $dependencia[0]["DESCRIPCION"];?></small>
	</h4>
</div>

<div class="modal-body">
	<div class="table-responsive" >
		<table class="table table-responsive">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Nombre</th>
					<th>Ext.</th>
					<th>Correo </th>
					<th>Despacho</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i=0;
				foreach ($usuarios as $datos):
					$i++;
					echo "<tr>";
						echo "<td class='text-left'><small>" . $i. "</small></td>";
						echo "<td class='text-left'><small>" . $datos["NOM_USUARIO"] . " " . $datos["APE_USUARIO"]. "</small></td>";
                        echo "<td class='text-center'><small>" . $datos['EXT_USUARIO'] . "</small></td>";
                        echo "<td class='text-center'><small>" . $datos['MAIL_USUARIO'] . "</small></td>";
						echo "<td class='text-left'><small>" . $datos['DESCRIPCION'] . "</small></td>";
					echo "</tr>";
					
				endforeach;
			?>		
			</tbody>
		</table>
	</div>	
</div>

<div class="modal-footer" >

</div>