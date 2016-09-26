<div class="container">
	<div class="page-header">
		<h2>ADICIONAR/EDITAR PERMISOS</h2>
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
					foreach ($PADRE as $item): ?>
						<option value='<?php echo $item['ID_MODULOS'];?>' <?php if($item['ID_MODULOS']==$ciu){ echo 'selected="selected"'; }?>><?php echo $item['NOMBRE_MODULO'];?></option>
					<?php endforeach ?>						
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Nombre del Permiso : *</label>
				<input type="text" name="permiso" id="permiso" class="form-control" placeholder="Permiso" value="<?php if( $this->input->post() ){echo set_value('permiso');}elseif( !$nuevo ){echo $HIJO[0]["NOMBRE_PERMISO"];} ?>" />
			</div>
		</div>		
		<div class="row">
			<div class='col-md-3'>
				<label class="control-label">Estado : *</label>
				<select name="estado" id="estado" class="form-control" >
					<option value='' >Seleccione...</option>
					<?php 
					$estado = '';
					if( $this->input->post() )
						$estado = set_value('estado');
					else if( !$nuevo )
						$estado = $HIJO[0]["ESTADO"];					
					?>					
					<option value='1' <? if($estado == '1') { echo "selected "; }  ?>>Activo</option>
					<option value='2' <? if($estado == '2') { echo "selected "; }  ?>>Bloqueado</option>
				</select>
			</div>
			<div class='col-md-3'>
				<label class="control-label">Perfil : *</label>
				<select name="perfil" id="perfil" class="form-control" >
					<option value='' >Seleccione...</option>
					<?php 
					$perfil = '';
					if( $this->input->post() )
						$perfil = set_value('perfil');
					else if( !$nuevo )
						$perfil = $HIJO[0]["PERFIL"];					
					?>					
					<option value='SUPER ADMIN' <? if($perfil == 'SUPER ADMIN') { echo "selected "; }  ?>>SUPER ADMIN</option>
					<option value='ADMIN' <? if($perfil == 'ADMIN') { echo "selected "; }  ?>>ADMIN</option>
					<option value='USER' <? if($perfil == 'USER') { echo "selected "; }  ?>>USER</option>
				</select>
			</div>
			<div class="col-md-6">
				<label class="control-label">Descripción : *</label>
				<textarea class="form-control" name="descripcion"  rows="1"><?php
					$descripcion = '';
					if( $this->input->post() )
						$descripcion = set_value('descripcion');
					else if( !$nuevo )
						$descripcion = $HIJO[0]["DESCRIPCION"];				
					echo $descripcion;
				?></textarea>
			</div>			
		</div>		
		<div class="row">
			<div class='col-md-3'>
				<label class="control-label">Permiso por defecto? : </label>
				<select name="xdefecto" id="xdefecto" class="form-control" >
					<option value='2' >Seleccione...</option>
					<?php 
					$xdefecto = '';
					if( $this->input->post() )
						$xdefecto = set_value('xdefecto');
					else if( !$nuevo )
						$xdefecto = $HIJO[0]["POR_DEFECTO"];					
					?>					
					<option value='1' <? if($xdefecto == '1') { echo "selected "; }  ?>>Si</option>
					<option value='2' <? if($xdefecto == '2') { echo "selected "; }  ?>>No</option>
				</select>
			</div>
			<div class='col-md-4'>
				<label class="control-label">Por defecto para que tipo de usuario? : </label>
				<select name="tipo_usuario" id="tipo_usuario" class="form-control" >
					<option value='0' >Seleccione...</option>
					<?php 
					$tipo_usuario = '';
					if( $this->input->post() )
						$tipo_usuario = set_value('tipo_usuario');
					else if( !$nuevo )
						$tipo_usuario = $HIJO[0]["TIPO_USUARIO"];					
					?>					
					<option value='1' <? if($tipo_usuario == '1') { echo "selected "; }  ?>>Funcionario de Planta</option>
					<option value='2' <? if($tipo_usuario == '2') { echo "selected "; }  ?>>Contratista</option>
					<option value='3' <? if($tipo_usuario == '3') { echo "selected "; }  ?>>TODOS</option>
				</select>
			</div>		
		</div><br>
		<div class="row" >
			<?php 
				if( $nuevo ){
					$botonValue = 'Guardar datos';
				}else{
					$botonValue = 'Actualizar datos';
					echo '<input type="hidden" name="idModulo" value="' . $HIJO[0]["ID_PERMISO"] . '" />';
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
						Listado de Permisos
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
					$enlace = site_url().'menu/menu/editObjeto/permisos/x';
					echo '<a class="btn btn-warning" href="' . $enlace . '">PERMISO NUEVO</a>';
					echo "</td>";
				}
			?>		
		</tr>
		<tr class="info">
			<td ><p class="text-center"><strong>ID</strong></p></td>
			<td ><p class="text-center"><strong>M&oacute;dulo </strong></p></td>
			<td ><p class="text-center"><strong>Perfil - Permiso</strong></p></td>
			<td ><p class="text-center"><strong>Descripci&oacute;n</strong></p></td>
			<td ><p class="text-center"><strong>Editar </strong></p></td>
		</tr>
		<?php 
		$i=0;
		foreach ($HIJO as $lista):
			echo "<tr>";
			echo "<td class='text-center'><small>" . $lista['ID_PERMISO'] . "</small></td>";
			$enlace = site_url().'menu/menu/editObjeto/modulos/' . $lista['FK_ID_MODULOS'];
			echo "<td class='text-center'><small><a href='" . $enlace . "'>" . $lista['NOMBRE_MODULO'] . "</a></small></td>";
			echo "<td><span class='label label-primary'>".$lista['PERFIL']."</span> - <small>" . $lista['NOMBRE_PERMISO'] . "</small></td>";
			echo "<td>";
			if($lista['POR_DEFECTO']==1)
				echo "<span class='label label-primary'>PERMISO POR DEFECTO</span> - ";
			echo "<small>" . $lista['DESCRIPCION'] . "</small></td>";
			echo "<td class='text-center'>";
			$enlace = site_url().'menu/menu/editObjeto/permisos/' .$lista['ID_PERMISO'];
			if( $lista['ESTADO']==1){
				$valor = 'Activo';
				$clase = "btn btn-success";
			}else{
				$valor = 'Bloqueado';
				$clase = "btn btn-danger";
			}
			echo '<a class="' . $clase . '" href="' . $enlace . '">' .  $valor . ' <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
			 			

			echo "</td>";
			echo "</tr>";
		endforeach ?>
	</table>
		</div>
	</div>
</div>