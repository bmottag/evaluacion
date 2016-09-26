<script>
	$(function(){ 

	$(".btn-success").click(function () {	
			var oID = $(this).attr("id");

            $.ajax ({
                type: 'POST',
                url: base_url + 'gh_evaluacion/admin_evaluacion/cargarModal',
                data: {'tipoGerente': oID},
                cache: false,
                success: function (data) {
                    $('#tablaDatos').html(data);
                }
            });
	});				
		
	});
</script>
<div class="container"> 
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						PLANTILLA
					</h4>
				</div>
			</div>
		</div>			
	</div>
		<div class="alert alert-info" role="alert">
			<strong>Plantilla: </strong>
			 Una para Direcciones Territoriales y otra para Nivel Central. 
			 <br><strong>Bot&oacute;n "Macroproceso": </strong> Permite adicionar, ver y eliminar los macroprocesos de la plantilla.
			<br><strong>Nota: </strong>
			Se pueden crear los acuerdos a partir de la plantilla unicamente si:
			<ul>
			<li>La plantilla esta completa.(Direcciones Territoriales con peso programado = 200; Nivel Central con peso programado = 100).</li>
			<li>No existe ningun acuerdo creado para la vigencia actual para cada tipo de gerente p&uacute;blico.</li>
			</ul>
		</div>	
    
<?php
$retornoExito = $this->session->flashdata('retornoExito');
if ($retornoExito) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <?php echo $retornoExito ?>
    </div>
    <?php
}

$retornoError = $this->session->flashdata('retornoError');
if ($retornoError) {
    ?>
    <div class="alert alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <?php echo $retornoError ?>
    </div>
    <?php
}
?>  

<?php 
if(!$peso_total)
{ 
?>
	 <div class='alert alert-danger text-center'><strong>Atenci&oacute;n: </strong>No estan los datos.</div>					
<?php
}else{  
?>    
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="info">
					<td><p class="text-center"><strong>ID</strong></p></td>
					<td><p class="text-center"><strong>Tipo Gerente P&uacute;blico</strong></p></td>
					<td><p class="text-center"><strong>Peso Max. Permitido</strong></p></td>
					<td><p class="text-center"><strong>Peso Programado</strong></p></td>
					<td><p class="text-center"><strong>Asignar Macro</strong></p></td>
					<td><p class="text-center"><strong>Crear Acuerdos </strong></p></td>
				</tr>
				<?php
					foreach ($peso_total as $datos):
						$bandera = false;
						echo "<tr>";
						echo "<td class='text-center'><small>" . $datos['TIPO_GERENTE_PUBLICO'] . "</small></td>";
						echo "<td ><small>";
						switch ($datos['TIPO_GERENTE_PUBLICO']) {
								case 1:
										echo "DIRECCIONES TERRITORILES";
										$pesoMax = $infoArea[0]['PESO_AREA'] + $infoArea[1]['PESO_AREA'];//peso maximo que se puede programar
										if($acuerdoTerritorial>0){
											$bandera = true;
										}
										break;
								case 2:
										echo "NIVEL CENTRAL";
										$pesoMax = 100;//peso maximo que se puede programar ---valor por defecto
										if($acuerdoDireccion>0){
											$bandera = true;
										}
										break;
						}
						echo "</small></td>";
						echo "<td class='text-center'><small>" . $pesoMax . "</small></td>";
						echo "<td class='text-center'><small>" . $datos['PESO'] . "</small></td>";
						echo "<td class='text-center'>";
						
						$modal = "modal" . $datos['TIPO_GERENTE_PUBLICO'];
				?>
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="<?php echo $datos['TIPO_GERENTE_PUBLICO']; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Macroproceso
						</button>
                                                
				<?php
						echo "</td>";
						echo "<td class='text-center'>";
						//solo se puede crear acuerdo si esta la programacion completa y no hay ninguna programacion para la vigencia actual
						if($datos['PESO'] != $pesoMax ){
							echo "Completar el peso requerido.";
						}else{
							if($bandera){
								echo  "Existen acuerdos para la vigencia actual";
							}else{
				?>		
						<a class='btn btn-primary' href='<?php echo base_url('gh_evaluacion/admin_evaluacion/aplicarPlantilla/' . $datos['TIPO_GERENTE_PUBLICO']) ?>' >
								<span class="glyphicon glyphicon-plus" aria-hidden="true"> </span>  Crear Acuerdo
						</a>
				<?php
							}
						}
						echo "</td>";
						echo "</tr>";
					endforeach;
				?>
			</table>
		</div>
	</div>
	<?php }	?>
</div>

<!--INICIO Modal para adicionar MACROPROCESO -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar MACROPROCESO -->