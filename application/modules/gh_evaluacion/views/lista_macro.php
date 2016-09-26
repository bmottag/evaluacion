<script>
	$(function(){ 

		$(".btn-warning").click(function () {	
				var oID = $(this).attr("id");

				$.ajax ({
					type: 'POST',
					url: base_url + 'gh_evaluacion/cargarModal_compromiso',
					data: {'idAsignarMacro': oID},
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
						ACUERDO - CONCERTACI&Oacute;N DE COMPROMISOS
					</h4>
				</div>
			</div>
		</div>			
	</div>

		<div class="alert alert-info" role="alert">
			<strong>Lista </strong>de macroprocesos del acuerdo. El evaluador tiene la opci&oacute;n
			de adicionar o eliminar los compromisos.
			<br><strong>Bot&oacute;n "Compromiso": </strong> Permite adicionar, ver y eliminar los compromisos del macroproceso.
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

<!--INICIO DATOS DEPENDENCIA -->
    <div class="well">
        <div class="row">
            <div class="col-md-5">	
					<strong class='text-error'>DEPENDENCIA / TERRITORIAL :</strong><br />
					<?php echo $acuerdo[0]->DESCRIPCION; ?>
					<br><br><a class="btn btn-success" href=" <?php echo base_url().'gh_evaluacion/asignarMacro/'; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a>       
            </div>
            <div class="col-md-4">
					<strong class='text-error'>ID ACUERDO: </strong><?php echo $acuerdo[0]->ID_ACUERDO; ?><br/>
					<strong class='text-error'>VIGENCIA: </strong><?php echo $acuerdo[0]->VIGENCIA; ?><br />
					<strong class='text-error'><?php echo $usuarioEvaluador['cargo'];?>: </strong><?php echo $usuarioEvaluador['nom_usuario'] . ' ' . $usuarioEvaluador['ape_usuario'];?><br/>
                    <strong class='text-error'>Gerente P&uacute;blico: </strong><?php echo $usuarioJefe['nom_usuario'] . ' ' . $usuarioJefe['ape_usuario'];?>
            </div>
            <div class="col-md-3">
					<strong class='text-error'>Tipo Gerente Público :</strong><br />
                    <?php 
						switch ($acuerdo[0]->TIPO_GERENTE_PUBLICO) {
								case 1:
										echo "DIRECCIONES TERRITORILES";
										break;
								case 2:
										echo "NIVEL CENTRAL";
										break;
						}
					?>
            </div>
        </div>
    </div>
<!--FIN DATOS DEPENDENCIA -->
    
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover table-condensed">
				<tr class="info">
					<td><p class="text-center"><strong>&Aacute;rea</strong></p></td>
					<td><p class="text-center"><strong>Macroproceso</strong></p></td>
					<td><p class="text-center"><strong>Peso asignado</strong></p></td>
					<td><p class="text-center"><strong>Peso programado</strong></p></td>
					<td><p class="text-center"><strong>Compromiso </strong></p></td>
				</tr>
				<?php
					foreach ($macro as $lista):
						echo "<tr>";					
						echo "<td class='text-center'><small>" . $lista->AREA . "</small></td>";
						echo "<td ><small>" . $lista->MACROPROCESO . "</small></td>";
						echo "<td class='text-center'><small>" . $lista->PESO_ASIGNADO . "</small></td>";
						echo "<td class='text-center'><small>" . $lista->PESO_PROGRAMADO . "</small></td>";
						echo "<td class='text-center'>";
                                                
						$idAsignarMacro = $lista->ID_ASIGNAR_MACRO;
				?>
						<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal" id="<?php echo $idAsignarMacro; ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Compromiso
						</button>
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
	<div class="modal-dialog modal-lg" role="document">	
		<div class="modal-content" id="tablaDatos">

		</div>
	</div>
</div>                       
<!--FIN Modal para adicionar MACROPROCESO -->