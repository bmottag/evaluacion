<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                LISTA DE ADMINISTRADORES POR M&Oacute;DULO
            </h4>
        </div>
    </div>	
	<div class="well">
		<form  name="formModulos" id="formModulos" role="form" method="post" >
		<div class="row">
			<div class="col-md-7">
				<label class="control-label">Seleccionar la lista que desea ver : *</label>
				<select name="tipoLista" id="tipoLista" class="form-control" >
					<option value='' >Seleccione...</option>
					<?php 
					$ciu = '';
					if( $this->input->post() )
						$ciu = $this->input->post('tipoLista');
				
					foreach ($tipoLista as $item): ?>
						<option value='<?php echo $item->ID_PERMISO;?>' <?php if($item->ID_PERMISO==$ciu){ echo 'selected="selected"'; }?>><?php echo $item->PERFIL . ' - ' . $item->NOMBRE_MODULO . ' - ' . $item->NOMBRE_PERMISO;?></option>
					<?php endforeach ?>						
				</select>
			</div>
			<div class="col-md-5">
				<br><input type="submit" name="Button" value="Ver lista" class="btn btn-primary"/>
			</div>
		</div>		
		</form>
	</div>
</div>


<!--LISTA DE MODULOS -->

<div class="container">
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

	<?php if( $this->input->post('tipoLista') && $lista ){ ?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
						LISTADO
					</h4>
				</div>
			</div>
		</div>			
	</div>
	
	
		<div class="alert alert-info" role="alert">
			<strong>PERFIL : </strong><?php echo $infoPermiso[0]->PERFIL; ?> -----
			<strong>M&Oacute;DULO : </strong><?php echo $infoPermiso[0]->NOMBRE_MODULO; ?> -----
			<strong>PERMISO : </strong><?php echo $infoPermiso[0]->NOMBRE_PERMISO; ?><br>
			<strong>DESCRIPCI&Oacute;N : </strong><?php echo $infoPermiso[0]->DESCRIPCION; ?>
		</div>
	
	
	<div class="row">
		<div class="col-md-12">
	<table class="table table-striped table-hover table-condensed">
		<tr class="info">
			<td ><p class="text-center"><strong>Nombre</strong></p></td>
			<td ><p class="text-center"><strong>Nó. de Cédula </strong></p></td>
			<td ><p class="text-center"><strong>Extensi&oacute;n </strong></p></td>
			<td ><p class="text-center"><strong>Correo </strong></p></td>
			<td ><p class="text-center"><strong>Dependencia / Grupo </strong></p></td>
		</tr>
		<?php 
		$i=0;
		foreach ($lista as $item):
			echo "<tr>";
			echo "<td><small>" . $item['NOM_USUARIO'] . ' ' . $item['APE_USUARIO'] . "</small></td>";
			echo "<td class='text-center'><small>" . $item['NUM_IDENT'] . "</small></td>";
			echo "<td class='text-center'><small>" . $item['EXT_USUARIO'] . "</small></td>";
			echo "<td><small>" . $item['MAIL_USUARIO'] . "</small></td>";
			echo "<td><small>" . $item['DESCRIPCION'] . "</small></td>";
			echo "</tr>";
		endforeach ?>
	</table>
		</div>
	</div>
	<?php } ?>
</div>