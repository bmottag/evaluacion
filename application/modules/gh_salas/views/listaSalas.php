<script type="text/javascript">
function valida(form) {
	var ok = true;

	for (var i=0; i<form.length; i++) {
		if(form[i].type =='text') {
		form.fecha.value = form[i].value;
			if (form[i].value == null || form[i].value.length == 0 || /^\s*$/.test(form[i].value)){
				ok = false;
			}
		}
	}
  
	if(ok == false)
		alert('Debe indicar la fecha de la solicitud');
	return ok;
}
</script>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                LISTA DE SALAS
            </h4>
        </div>
    </div>	
	<!-- Mensajes de alerta -->
	<?php if(validation_errors()){?>
		<div class="row">
				<div class="alert alert-danger">
					<?php echo validation_errors(); ?>
				</div>
		</div>
	<?php } ?>	
	<table class="table table-bordered table-striped table-hover table-condensed">
		<tr class="info">
			<td colspan="7"><h4>Indicar fecha de solcitud para reservar la sala</h4></td>
		</tr>	
		<tr class="info">
			<td ><p class="text-center"><strong>Nombres</strong></p></td>
			<td ><p class="text-center"><strong>Ubicaci&oacute;n </strong></p></td>
			<td ><p class="text-center"><strong>Capacidad</strong></p></td>
			<td ><p class="text-center"><strong>Caracter&iacute;sticas </strong></p></td>
			<td ><p class="text-center"><strong>Imagen </strong></p></td>
			<td ><p class="text-center"><strong>Fecha solicitud</strong></p></td>
			<td ><p class="text-center"><strong>Reservar</strong></p></td>
		</tr>
		<?php 
		foreach ($salas as $data):
			echo "<tr>";
			echo "<td>" . $data['SALA_NOMBRE'] . "</td>";
			echo "<td>" . $data['UBICACION'] . "</td>";
			echo "<td>" . $data['CAPACIDAD'] . "</td>";
			echo "<td>" . $data['CARACTERISTICAS'] . "</td>";
			echo "<td><img src=" . base_url() . "files/salas/" . $data['IMAGEN'] . "></td>";
			$attributes = $data['ID_SALA'];
			echo '<form  name="' . $attributes . '" id="' . $attributes . '" method="post" onsubmit="return valida(this)">';
			echo '<td>';
		?>			
		<script type="text/javascript">
			$(function(){	
				$('#datetimepicker<?php echo $data['ID_SALA']; ?>').datepicker({		
					dateFormat: 'dd/mm/yy',
					minDate:'now'
				});
			})
		</script>
				<input type="hidden" name="salaId" value="<?php echo $data['ID_SALA']; ?>" />
				<input type="hidden" name="nombreSala" value="<?php echo $data['SALA_NOMBRE']; ?>" />
				<input type="hidden" id="fecha" name="fecha">
				<input type='text' class="form-control" name='datetimepicker<?php echo $data['ID_SALA']; ?>' id='datetimepicker<?php echo $data['ID_SALA']; ?>' />
		<?php  
			echo '</td>';
			echo "<td>";
			echo form_submit('Button','Reservar', 'class="btn btn-small btn-primary"');
			echo "</td>";
			echo '</form>';
			echo "</tr>";
		endforeach ?>
	</table>
</div>