<h2>Recordatorio de usuario y contrase&ntilde;a Sistema de Gesti&oacute;n Humana - DANE</h2>
<hr/>
<br/>
<p>Bogot&aacute; D.C.,&nbsp; <?php echo date('l jS \of F Y h:i:s A'); ?></p>
<p>
Se&ntilde;or(a):<br/>
<b><?php echo $nombres." ".$apellidos; ?></b><br/>
</p>

<?php	if ($found){ ?> 

			<p>El Sistema de Gesti&oacute;n Humana - DANE Se permite recordarle su usuario y contrase&ntilde;a de acceso al sistema: 
			<br/><br/>
			<table width="30%">
			<tr>
  				<td><b>Login:</b></td>
  				<td><?php if(isset($log_usuario)) echo $log_usuario; ?></td>
			</tr>
			<tr>
  				<td><b>Password:</b></td>
  				<td><?php if (isset($pas_usuario)) echo $pas_usuario; ?></td>
			</tr>
			</table>
			</p>
			<p>Gracias por utilizar el Sistema de Gesti&oacute;n Humana. </p>

<?php   } 
		else{ ?>

			<p>El Sistema de Gesti&oacute;n Humana <b>NO</b> ha encontrado usuarios registrados con la direcci&oacute;n de correo indicada.</p>
			<p>Agradecemos por favor se comunique directamente con la Oficina de Gesti&oacute;n Humana de la Entidad para solucionar este inconveniente.</p>
			<p>Gracias.</p>

<?php   } ?>



