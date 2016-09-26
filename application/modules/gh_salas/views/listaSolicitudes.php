<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                <?php echo $titulo; ?>
            </h4>
        </div>
    </div>	
	
	<div class="row">
		<div class="col-md-12">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<tr class="info">
			<td ><p class="text-center"><strong>No. registro</strong></p></td>
			<td ><p class="text-center"><strong>Sala</strong></p></td>
			<td ><p class="text-center"><strong>Fecha</strong></p></td>
			<td ><p class="text-center"><strong>Hora</strong></p></td>
			<td ><p class="text-center"><strong>T&iacute;tulo</strong></p></td>
			<td ><p class="text-center"><strong>Responsable</strong></p></td>
			<td ><p class="text-center"><strong>Estado</strong></p></td>
			<td ><p class="text-center"><strong>Cancelar <br>solicitud</strong></p></td>			
		</tr>
		<?php 
		foreach ($solicitudes as $lista):
			$estadoId = $lista['FK_ID_ESTADO'];
			$fechaSolicitud = $lista['FECHA_APARTADO'];	
			$hoy = date('d/m/y');
			echo "<tr>";
			echo "<td class='text-center'><small>" . $lista['ID_SOLICITUD_SALA'] . "</small></td>";
			echo "<td><small>" . $lista['SALA_NOMBRE'] . "</small></td>";
			echo "<td class='text-center'><small>" . $fechaSolicitud . "</small></td>";
			echo "<td class='text-center'><small>" . $lista['HORA_INICIO'] . " -  " . $lista['HORA_FINAL'] . "</small></td>";
			echo "<td><small>" . $lista['TITULO_EVENTO'] . "</small></td>";
			echo "<td><small>" . strtoupper($lista['NOM_USUARIO']) . ' ' . strtoupper($lista['APE_USUARIO']) . "</small></td>";
			echo "<td class='text-center'><span class='label " . $lista["CLASE"]. "'>".$lista['ESTADO']."</span></td>";
			echo "<td class='text-center'>";
			if( ( $estadoId == 1 || $estadoId == 2 ) && ( $fechaSolicitud >= $hoy ) )
			{
				$hidden = array( 'idSolicitud' => $lista['ID_SOLICITUD_SALA'],
								  'estadoId'	=> 4 );
				echo form_open('gh_salas/cancelar_solicitud', '', $hidden);				
				echo '<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-trash" aria-hidden="true"></button>';
				echo form_close(); 				
			}else echo '<a class="btn" href="#" disabled><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
			echo "</td>";	
			echo "</tr>";
		endforeach ?>
	</table>
	<?php if(isset($links)){ ?>
	<div class="row">
		<div class="col-md-12">
			<nav>
			<ul class="pagination">
				<?php echo $links; ?>
			</ul>
			</nav>		
		</div>
	</div>
	<?php } ?>	
		</div>
	</div>
</div>