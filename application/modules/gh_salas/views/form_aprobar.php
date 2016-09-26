<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                FORMULARIO APROBAR SOLICITUDES DE SALAS
            </h4>
        </div>
    </div>
	<div class="col-md-6">
		<div class="well">
			<div class="row">
				<div class="col-md-12">
					<legend class="text-error">Detalle de la solicitud</legend>	
					<?php 
					foreach ($solicitudes as $data):
							echo "<strong>Sala : </strong>" . $data['SALA_NOMBRE'] . "<br>";
							echo "<strong>Fecha : </strong>" . $data['FECHA_APARTADO'] . "<br>";
							echo "<strong>Hora Inicio : </strong>" . $data['HORA_INICIO'] . "<br>";
							echo "<strong>Hora Final : </strong>" . $data['HORA_FINAL'] . "<br>";
							echo "<strong>T&iacute;tulo del Evento : </strong>" . $data['TITULO_EVENTO'] . "<br>";
							echo "<strong>No. Personas : </strong>" . $data['NRO_PERSONAS'] . "<br>";
							echo "<strong>Descripci&oacute;n : </strong>";
							echo $data['DESCRIPCION'] . "<br>";
							echo "<strong>Responsable : </strong>";
							echo $data['NOM_USUARIO'] . ' ' . $data['APE_USUARIO'] . "<br>";
					endforeach;
					//Formulario de aprobacion				
					echo '<legend class="text-error"></legend>';
					$hidden = array( 'idSolicitud' => $data['ID_SOLICITUD_SALA'] );
					echo form_open('gh_salas/admin_salas/update_estado_solicitud', '', $hidden);
					echo '<button class="btn btn-primary" type="submit" name="estadoId" value="2">Aprobar</button>';
					echo ' ';										
					echo '<button class="btn btn-danger" type="submit" name="estadoId" value="3">Denegar</button>';
					echo form_close();							
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="well">
			<div class="row">
				<div class="col-md-12">	
				<legend class="text-error">Horarios reservados: <?php echo $data['SALA_NOMBRE'] . ' / ' . $data['FECHA_APARTADO']; ?> </legend>
				<table class="table table-bordered table-striped table-hover table-condensed">
					<tr class="info">
						<td ><p class="text-center"><strong>No. registro</strong></p></td>
						<td ><p class="text-center"><strong>Hora</strong></p></td>
						<td ><p class="text-center"><strong>Responsable</strong></p></td>
						<td ><p class="text-center"><strong>Ext.</strong></p></td>
					</tr>
					<?php 
					foreach ($solApartadas as $data):
						echo "<tr>";
						echo "<td class='text-center'>" . $data['ID_SOLICITUD_SALA'] . "</td>";
						echo "<td class='text-center'>" . $data['HORA_INICIO'] . " -  " . $data['HORA_FINAL'] . "</td>";						
						echo "<td>" . $data['NOM_USUARIO'] . ' ' . $data['APE_USUARIO'] . "</td>";
						echo "<td class='text-center'>" . $data['EXT_USUARIO'] . "</td>";
						echo "</tr>";
					endforeach ?>
				</table>
			</div>
		</li>		
		<?php if( isset($msj) ){?>
		<li class="span3" >
		    <div class="alert alert-success">
				<?php echo $msj; ?>
			</div>
		</li>
		<?php } ?>
		<!-- Mensajes de alerta -->
		<?php if(validation_errors()){?>
			<div class="span8 offset2" >
				<div class="alert alert-error">
					<?php echo validation_errors(); ?>

				</div>
			</div>
		<?php } ?>		
		
		
		
	</ul>
				</div>
			</div>
		</div>
	</div>	
</div>