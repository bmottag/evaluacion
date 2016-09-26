	<script type="text/javascript" src="<?php echo base_url("js/login/login.js"); ?>"></script>
<div class="container">
	<div class="page-header">
		<h2>Creaci&oacute;n de Usuarios</h2>
	</div>
	<div class="row" align="center">
		<div style="width:50%;" align="center">
			<div class="alert alert-success">
				<span class="glyphicon glyphicon-ok"></span>
				<?php echo $mensaje; ?>
			</div>
		</div>
	</div>	
    <div class="row">
    	<div class="col-md-12">	  				
			<table width="30%" align="center">
			<tr>
			  	<td><b>Nombre: </b></td>
			  	<td><?php echo $usuario["nombres"]." ".$usuario["apellidos"]; ?></td>
			</tr>
			<tr>
			  	<td><b>Correo Electr&oacute;nico: </b></td>
			  	<td><?php echo $usuario["mail_usuario"]; ?></td>
			</tr>
			<tr>
				<td><b>Usuario: </b></td>
				<td><?php echo $usuario["log_usuario"]; ?></td>
			</tr>
			<tr>
				<td><b>Contrase&ntilde;a: </b></td>
				<td><?php echo "Digite la contrase&ntilde;a que utiliza para ingresar a su equipo.";// $usuario["pas_usuario"]; ?></td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<button type="button" id="btnCrearCancelar" name="btnCrearCancelar" class="btn btn-success">Aceptar</button>
				</td>
			</tr>
			</table>
		</div>	
	</div>
	<p>&nbsp;</p>	
	<p>&nbsp;</p>
</div>	