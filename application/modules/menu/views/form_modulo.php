<div class="container">
	<div class="page-header">
		<h2>ADICIONAR/EDITAR M&Oacute;DULO</h2>
	</div>
	<!-- Mensaje del controlador -->
	<?php if( $msj != ''){  ?>
		<div class="alert <?php echo $clase; ?> alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Nota : </strong> 
			<?php 
				echo $msj;
			?>
		</div>
	<?php } ?>	
	<!-- FIN Mensaje del controlador -->
	<div class="well">
		<form  name="formModulos" id="formModulos" role="form" method="post" >
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Tema : *</label>
				<select name="tema" id="tema" class="form-control" >
					<option value='' >Seleccione...</option>
					<?php 
					$ciu = '';
					if( $this->input->post() )
						$ciu = set_value('tema');
					else if( !$nuevo )
						$ciu = $HIJO[0]["FK_ID_TEMA"];					
					foreach ($PADRE as $item): ?>
						<option value='<?php echo $item['ID_TEMA'];?>' <?php if($item['ID_TEMA']==$ciu){ echo 'selected="selected"'; }?>><?php echo $item['NOMBRE_TEMA'];?></option>
					<?php endforeach ?>						
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Nombre del M&oacute;dulo : *</label>
				<input type="text" name="modulo" id="modulo" class="form-control" placeholder="M&oacute;dulo" value="<?php if( $this->input->post() ){echo set_value('modulo');}elseif( !$nuevo ){echo $HIJO[0]["NOMBRE_MODULO"];} ?>" />
			</div>
		</div>		
		<br>
		<div class="row" >
			<?php 
				if( $nuevo ){
					$botonValue = 'Guardar datos';
				}else{
					$botonValue = 'Actualizar datos';
					echo '<input type="hidden" name="idModulo" value="' . $HIJO[0]["ID_MODULOS"] . '" />';
				}
			?>
			<div class="col-md-6">
				<input type="submit" name="Button" value="<?php echo $botonValue; ?>" class="btn btn-primary"/>
			</div>
		</div>
		</form>
	</div>
</div>


<!--LISTA DE MODULOS -->

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						Listado de M&oacute;dulos
					</h4>
				</div>
			</div>
		</div>			
	</div>
	<div class="row">
		<div class="col-md-12">
	<table class="table table-striped table-hover table-condensed">
		<tr>
			<?php 
				if( !$nuevo ){
					echo "<td colspan='2'></td>";
					echo "<td colspan='2' class='text-right'>";
					$enlace = site_url().'menu/menu/editObjeto/modulos/x';
					echo '<a class="btn btn-warning" href="' . $enlace . '">M&Oacute;DULO NUEVO</a>';
					echo "</td>";
				}
			?>		
		</tr>
		<tr class="info">
			<td ><p class="text-center"><strong>ID</strong></p></td>
			<td ><p class="text-center"><strong>Tema </strong></p></td>
			<td ><p class="text-center"><strong>M&oacute;dulo</strong></p></td>
			<td ><p class="text-center"><strong>Editar </strong></p></td>
		</tr>
		<?php 
		$i=0;
		foreach ($HIJO as $lista):
			echo "<tr>";
			echo "<td class='text-center'><small>" . $lista['ID_MODULOS'] . "</small></td>";
			echo "<td class='text-center'><small>" . $lista['NOMBRE_TEMA'] . "</small></td>";
			echo "<td ><small>" . $lista['NOMBRE_MODULO'] . "</small></td>";
			echo "<td class='text-center'>";
			$enlace = site_url().'menu/menu/editObjeto/modulos/' .$lista['ID_MODULOS'];
			echo '<a class="btn btn-success" href="' . $enlace . '">EDITAR <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
			echo "</td>";
			echo "</tr>";
		endforeach ?>
	</table>
		</div>
	</div>
</div>