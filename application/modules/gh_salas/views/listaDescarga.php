	<table border="1">
		<tr class="info">
			<td colspan="9"><h5 align="center">LISTA SOLICITUDES DE SALAS</h5>
			<?php
				echo '<h6 align="center"><strong>Reporte desde: </strong>' .  $this->input->post('fechaIni') ;
				echo '<strong> - Hasta: </strong>' . $this->input->post('fechaFin') . '</h6>';
			?>			
			</td>
		</tr>
		<tr class="info">
			<td ><p class="text-center"><strong>No. registro</strong></p></td>
			<td ><p class="text-center"><strong>SALA</strong></p></td>
			<td ><p class="text-center"><strong>FECHA</strong></p></td>
			<td ><p class="text-center"><strong>HORA</strong></p></td>
			<td ><p class="text-center"><strong>TÍTULO</strong></p></td>
			<td ><p class="text-center"><strong>RESPONSABLE</strong></p></td>
			<td ><p class="text-center"><strong>Ext.</strong></p></td>
			<td ><p class="text-center"><strong>No. PERSONAS</strong></p></td>
			<td ><p class="text-center"><strong>ESTADO</strong></p></td>
		</tr>
		<?php 
		foreach ($solicitudes as $data):
			echo "<tr>";
			echo "<td>" . $data['ID_SOLICITUD_SALA'] . "</td>";
			echo "<td>" . $data['SALA_NOMBRE'] . "</td>";
			echo "<td>" . $data['FECHA_APARTADO'] . "</td>";
			echo "<td>" . $data['HORA_INICIO'] . " -  " . $data['HORA_FINAL'] . "</td>";
			echo "<td>" . $data['TITULO_EVENTO'] . "</td>";
			echo "<td><small>" . $data['NOM_USUARIO'] . ' ' . $data['APE_USUARIO'] . "</small></td>";
			echo "<td>" . $data['EXT_USUARIO'] . "</td>";			
			echo "<td>" . $data['NRO_PERSONAS'] . "</td>";
			echo "<td>" . $data['ESTADO'] . "</td>";			
			echo "</tr>";
		endforeach ?>
	</table>