<script type="text/javascript" src="<?php echo base_url("js/menu/menu.js"); ?>"></script>	
<div class="container">
	<div class="page-header">
		<h2>ADICIONAR/EDITAR MEN&Uacute;</h2>
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
				<label class="control-label">M&oacute;dulo : *</label>
				<select name="modulo" id="modulo" class="form-control" >
					<option value='' >Seleccione...</option>
					<?php 
					$ciu = '';
					if( $this->input->post() )
						$ciu = set_value('modulo');
					else if( !$nuevo )
						$ciu = $HIJO[0]["FK_ID_MODULOS"];					
					foreach ($LISTA as $item): ?>
						<option value='<?php echo $item['ID_MODULOS'];?>' <?php if($item['ID_MODULOS']==$ciu){ echo 'selected="selected"'; }?>><?php echo $item['NOMBRE_MODULO'];?></option>
					<?php endforeach ?>						
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Permiso : *</label>
				<select name="permiso" id="permiso" class="form-control" >
					<option value='' >Seleccione...</option>
					<?php 
					$ciu = '';
					if( $this->input->post() )
						$ciu = set_value('modulo');
					else if( !$nuevo )
						$ciu = $HIJO[0]["FK_ID_PERMISOS"];					
					foreach ($PADRE as $item): ?>
						<option value='<?php echo $item['ID_PERMISO'];?>' <?php if($item['ID_PERMISO']==$ciu){ echo 'selected="selected"'; }?>><?php echo $item['PERFIL'] . ' - ' . $item['NOMBRE_PERMISO'];?></option>
					<?php endforeach ?>						
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Nombre del Men&uacute : *</label>
				<input type="text" name="men" id="men" class="form-control" placeholder="Menu" value="<?php if( $this->input->post() ){echo set_value('permiso');}elseif( !$nuevo ){echo $HIJO[0]["NOMBRE_MENU"];} ?>" />
			</div>
		</div>		
		<div class="row">
			<div class="col-md-6">
				<label class="control-label">Enlace : *</label>
				<input type="text" name="enlace" id="enlace" class="form-control" placeholder="Enlace" value="<?php if( $this->input->post() ){echo set_value('enlace');}elseif( !$nuevo ){echo $HIJO[0]["ENLACE"];} ?>" />
			</div>
			<div class="col-md-6">
				<label class="control-label">Orden: *</label>
				<select name="orden" id="orden" class="form-control" >
					<option value='' >Seleccione...</option>
					<?php 
					$orden = '';
					if( !$nuevo )
						$orden = $HIJO[0]["ORDEN"];					
					for ($i = 1; $i <= 9; $i++) { ?>
						<option value='<?php echo $i;?>' <?php if($i==$orden){ echo 'selected="selected"'; }?>><?php echo $i;?></option>
					<?php } ?>									
				</select>
			</div>		
		</div>
                    <div class="row">
			<div class="col-md-6">
				<label class="control-label">Imagen : *</label>
				<input type="text" name="imagen" id="imagen" class="form-control" placeholder="Imagen" value="<?php if( $this->input->post() ){echo set_value('imagen');}elseif( !$nuevo ){echo $HIJO[0]["IMG"];} ?>" />
			</div>
                </div>    
                <br>
		<div class="row" >
			<?php 
				if( $nuevo ){
					$botonValue = 'Guardar datos';
				}else{
					$botonValue = 'Actualizar datos';
					echo '<input type="hidden" name="idModulo" value="' . $HIJO[0]["ID_MENU"] . '" />';
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
						Listado Men&uacute
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
					$enlace = site_url().'menu/menu/editObjeto/menu/x';
					echo '<a class="btn btn-warning" href="' . $enlace . '">PERMISO NUEVO</a>';
					echo "</td>";
				}
			?>		
		</tr>
		<tr class="info">
			<td ><p class="text-center"><strong>Perfil - Permiso </strong></p></td>
			<td ><p class="text-center"><strong>Men&uacute;</strong></p></td>
			<td ><p class="text-center"><strong>Enlace</strong></p></td>
                        <td ><p class="text-center"><strong>Imagen</strong></p></td>
			<td ><p class="text-center"><strong>Editar </strong></p></td>
		</tr>
		<?php 
		$i=0;
		foreach ($HIJO as $lista):
			echo "<tr>";
			echo "<td><small><span class='label label-primary'>" . $lista['PERFIL'] . "</span> - " . $lista['NOMBRE_PERMISO'] . "</small></td>";
			echo "<td><small>" . $lista['NOMBRE_MENU'] . "</small></td>";
			echo "<td><small>" . $lista['ENLACE'] . "</small></td>";
                        echo '<td><small><span class="' . $lista['IMG'] . '" aria-hidden="true"></span></small>&nbsp;' . $lista['IMG'] . '</td>';
			echo "<td class='text-center'>";
			$enlace = site_url().'menu/menu/editObjeto/menu/' .$lista['ID_MENU'];
			echo '<a class="btn btn-success" href="' . $enlace . '">EDITAR <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
			echo "</td>";
			echo "</tr>";
		endforeach ?>
	</table>
		</div>
	</div>
</div>