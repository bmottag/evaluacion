<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                CAMBIAR EL ESTADO DE LA SALA
            </h4>
        </div>
    </div>	
		<!-- Mensajes de alerta -->
		<?php if($this->input->post()){?>
			<div class="alert alert-error">
				<h6><?php echo $text;?></h6>
			</div>
		<?php } ?>		
	<table class="table table-bordered table-striped table-hover table-condensed">
		<tr class="info">
			<td ><p class="text-center"><strong>Nombres</strong></p></td>
			<td ><p class="text-center"><strong>Ubicaci&oacute;n </strong></p></td>
			<td ><p class="text-center"><strong>Capacidad</strong></p></td>
			<td ><p class="text-center"><strong>Caracter&iacute;sticas </strong></p></td>
			<td ><p class="text-center"><strong>Imagen </strong></p></td>
			<td ><p class="text-center"><strong>Estado</strong></p></td>
		</tr>
		<?php 
		foreach ($salas as $data):
			echo "<tr>";
			echo "<td>" . $data['SALA_NOMBRE'] . "</td>";
			echo "<td>" . $data['UBICACION'] . "</td>";
			echo "<td>" . $data['CAPACIDAD'] . "</td>";
			echo "<td>" . $data['CARACTERISTICAS'] . "</td>";
			echo "<td class='text-center'><img src=" . base_url() . "files/salas/" . $data['IMAGEN'] . "></td>";

			$hidden = array( 'sala_Id' => $data['ID_SALA'], 'estado' => $data['ESTADO'] );
			echo form_open('', '', $hidden);
			echo "<td class='text-center'>";
			if( $data['ESTADO'] == 1 )
			{
				echo form_submit('Button','Desbloqueada', 'class="btn btn-primary"'); 
			}else echo form_submit('Button','Bloqueada', 'class="btn btn-danger"'); 
			echo "</td>";
			echo form_close();			
			
			echo "</tr>";
		endforeach ?>
	</table>
</div>