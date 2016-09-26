<?php 
    if(!$listaEvaluar)
	{
		echo "<div class='alert alert-danger text-center'><strong>Atenci&oacute;n: </strong>No hay Macroprocesos para realizar seguimiento.</div>";
	} else {
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						SEGUIMIENTO MACROPROCESOS
					</h4>
				</div>
			</div>
		</div>			
	</div>
		<div class="alert alert-info" role="alert">
			<strong>Lista </strong>de acuerdos a los que debe realizar seguimiento.
			<br><strong>Bot&oacute;n "Seguimiento": </strong> Permite ir a una nueva ventana para realizar el seguimiento a los macroprocesos que tiene asignados.
		</div>     
    
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="info">
					<td><p class="text-center"><strong>Dependencia / Territorial</strong></p></td>
					<td><p class="text-center"><strong>Tipo Gerente P&uacute;blico</strong></p></td>
					<td><p class="text-center"><strong>ID Acuerdo</strong></p></td>
					<td><p class="text-center"><strong>Seguimiento</strong></p></td>
		
				</tr>
				<?php
					foreach ($listaEvaluar as $lista):                 
						echo "<tr>";
						echo "<td ><small>" . $lista['DESCRIPCION'] . "</small></td>";
						echo "<td class='text-center'><small>";
						switch ($lista['TIPO_GERENTE_PUBLICO']) {
								case 1:
										echo "DIRECCIONES TERRITORILES";
										break;
								case 2:
										echo "NIVEL CENTRAL";
										break;
						}
						echo "</small></td>";
						echo "<td class='text-center'><small>" . $lista['ID_ACUERDO'] . "</small></td>";
						echo "<td class='text-center'>";
				?>
						<a class='btn btn-warning' href='<?php echo base_url('gh_evaluacion/seguimiento/' . $lista["ID_ACUERDO"]) ?>'  >
								<span class="glyphicon glyphicon-plus" aria-hidden="true"> </span>  Seguimiento
						</a>
				<?php
						echo "</td>";
						echo "</tr>";
					endforeach;
				?>
			</table>
		</div>
	</div>
</div>
<?php } ?>