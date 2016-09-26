<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                LISTA SOCITUDES DE SALAS PENDIENTES
            </h4>
        </div>
    </div>
	<table class="table table-bordered table-striped table-hover table-condensed">
		<tr class="info">
			<td ><p class="text-center"><strong>No. registro</strong></p></td>
			<td ><p class="text-center"><strong>Sala</strong></p></td>
			<td ><p class="text-center"><strong>Fecha</strong></p></td>
			<td ><p class="text-center"><strong>Hora</strong></p></td>
			<td ><p class="text-center"><strong>T&iacute;tulo</strong></p></td>
			<td ><p class="text-center"><strong>Responsable</strong></p></td>
			<td ><p class="text-center"><strong>Ext.</strong></p></td>
			<td ><p class="text-center"><strong>Estado</strong></p></td>
		</tr>
		<?php 
		foreach ($solicitudes as $data):
			echo "<tr>";
			echo "<td class='text-center'>" . $data['ID_SOLICITUD_SALA'] . "</td>";
			echo "<td>" . $data['SALA_NOMBRE'] . "</td>";
			echo "<td class='text-center'>" . $data['FECHA_APARTADO'] . "</td>";
			echo "<td class='text-center'>" . $data['HORA_INICIO'] . " -  " . $data['HORA_FINAL'] . "</td>";
			echo "<td>" . $data['TITULO_EVENTO'] . "</td>";
			echo "<td><small>" . strtoupper($data['NOM_USUARIO']) . ' ' . strtoupper($data['APE_USUARIO']) . "</small></td>";
			echo "<td class='text-center'>" . $data['EXT_USUARIO'] . "</td>";
			echo "<td class='text-center'><a class='btn btn-primary' href='" . $data['ID_SOLICITUD_SALA'] . "'><span class='glyphicon glyphicon-plus-sign' aria-hidden='true'></span></a></td>";
			echo "</tr>";
		endforeach ?>
	</table>
</div>