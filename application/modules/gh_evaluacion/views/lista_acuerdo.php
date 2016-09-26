<script>
	$(function(){ 

		$(".btn-success").click(function () {	
				var oID = $(this).attr("id");

				$.ajax ({
					type: 'POST',
					url: base_url + 'gh_evaluacion/cargarModal_macro',
					data: {'idOficina': oID},
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
						ACUERDO
					</h4>
				</div>
			</div>
		</div>			
	</div>
		<div class="alert alert-info" role="alert">
			<strong>Lista </strong>de acuerdos para la vigencia actual. El evaluador tiene la opci&oacute;n
			de adicionar o eliminar los macroprocesos y los compromisos del acuerdo.
			<br><strong>Bot&oacute;n "Macroproceso": </strong> Permite adicionar, ver y eliminar los macroprocesos del acuerdo.
			<br><strong>Bot&oacute;n "Concertaci&oacute;n de compromisos": </strong> Para ver los macroprocesos del acuerdo y asignar los compromisos.
			<br><strong>Bot&oacute;n "Acuerdo": </strong> Permite ir a una nueva ventana y ver el acuerdo en detalle.
			<br><strong>Nota: </strong>
			<ul>
			<li>Los bot&oacute;nes de "Concertaci&oacute;n de compromisos" y "Acuerdo" se habilitan cuando esta la programaci&oacute;n de los macroprocesos completa.</li>
			<li>El sistema no deja eliminar macroprocesos si tienen compromisos asignados, debe eliminar primero los compromisos.</li>
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
    
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="info">
					<td><p class="text-center"><strong>Dependencia / Territorial</strong></p></td>
					<td><p class="text-center"><strong>Tipo Gerente P&uacute;blico</strong></p></td>
					<td><p class="text-center"><strong>ID Acuerdo</strong></p></td>
					<td><p class="text-center"><strong>Peso Macroproceso</strong></p></td>
					<td><p class="text-center"><strong>Macroproceso </strong></p></td>
					<td><p class="text-center"><strong>Concertaci&oacute;n de compromisos</strong></p></td>
					<td><p class="text-center"><strong>Acuerdo</strong></p></td>
					<td><p class="text-center"><strong>Historial</strong></p></td>
				</tr>
				<?php
					foreach ($oficinas as $lista):
						$info_acuerdo = $this->consultas_eval_model->get_acuerdo($lista["ID_OFICINA"]);//informacion del acuerdo para esta oficina	

						echo "<tr>";
						echo "<td ><small>" . $lista['DESCRIPCION'] . "</small></td>";
						echo "<td class='text-center'><small>";
						switch ($lista['TIPO_GERENTE_PUBLICO']) {
								case 1:
										echo "DRIRECCIONES TERRITORILES";
										break;
								case 2:
										echo "NIVEL CENTRAL";
										break;
						}
						echo "</small></td>";
						echo "<td class='text-center'><small>" . $info_acuerdo['ID_ACUERDO'] . "</small></td>";
						echo "<td class='text-center'><small>" . $info_acuerdo['PESO_TOTAL'] . "</small></td>";
						echo "<td class='text-center'>";
						
						$modal = "modal" . $lista["ID_OFICINA"];
						
						//habilitar boton solo si el director o el subdirecor
						$deshabilitar = 'disabled';
						if($codDependencia<3){
							$deshabilitar = "";
						}
				?>
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal" id="<?php echo $lista["ID_OFICINA"]; ?>" <?php echo $deshabilitar; ?> >
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Macroproceso
						</button>
                                                
				<?php
						echo "</td>";
						echo "<td class='text-center'>";
						//solo se puede asignar comprmosisos si la programacion esta completa
						$pesoTotal = 0;
						if($info_acuerdo){ 
							$pesoTotal = $info_acuerdo["PESO_TOTAL"];
						}
						//si peso total igual a 100 0 200 se habilita boton para asignar compromisos y ver acuerdo                                            
						$tipoGerente = $lista['TIPO_GERENTE_PUBLICO'];
						
						if($tipoGerente==1){
							$pesoMax = 200;//peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
						}elseif($tipoGerente==2){
							$pesoMax = 100;//peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
						}	
						if($info_acuerdo && $pesoTotal == $pesoMax){
							$habilitar = '';
						}else{
							$habilitar = 'disabled';
						}	
				?>
						<a class='btn btn-warning' href='<?php echo base_url('gh_evaluacion/compromiso/' . $info_acuerdo["ID_ACUERDO"]) ?>' <?php echo $habilitar;?> <?php echo $deshabilitar; ?> >
								<span class="glyphicon glyphicon-plus" aria-hidden="true"> </span>  Concertación de compromisos
						</a>
				<?php
						echo "</td>";
						echo "<td>";//Boton para ver el acuerdo
				?>
						<a class='btn btn-info' href='<?php echo base_url('gh_evaluacion/acuerdo/' . $info_acuerdo["ID_ACUERDO"]) ?>' <?php echo $habilitar;?> >
								<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"> </span>  Acuerdo
						</a>
				<?php
						echo "</td>";
						echo "<td>";//Boton para ver el acuerdo
				?>
						<a class='btn btn-danger' href='<?php echo base_url('gh_evaluacion/historial/' . $info_acuerdo["ID_ACUERDO"]) ?>' <?php echo $habilitar;?> >
								<span class="glyphicon glyphicon-zoom-in" aria-hidden="true"> </span>  Historial
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

<!--INICIO Modal para adicionar MACROPROCESO -->
<div class="modal fade text-center" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">    
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar MACROPROCESO -->