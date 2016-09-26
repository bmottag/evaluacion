<div class="row col-md-12">
	<table class="table table-striped table-hover">
	<thead>
	<tr>
	  <th>Id. Certificado</th>
	  <th>Num. Identificaci&oacute;n</th>
	  <th>Nombre</th>
	  <th>Tipo Certificado</th>
	  <th>Estado</th>
	  <th>Fecha Radicado</th> 
	  <th>Fecha Generado</th> 
	  <th>Notificaciones</th>
	</tr>
	</thead>
	<tbody>
	<?php for ($i=0; $i<count($certificaciones); $i++){ ?>
			<tr>
				<td><?php echo $certificaciones[$i]["id_certificado"]; ?></td>
				<td><?php echo $certificaciones[$i]["num_ident"]; ?></td>
				<td><?php echo $certificaciones[$i]["nom_usuario"]. " " . $certificaciones[$i]["ape_usuario"]; ?></td>
				<td><?php echo $certificaciones[$i]["nom_certificado"]; ?></td>
				<td><?php echo $certificaciones[$i]["descripcion"]; ?></td>
				<td><?php echo $certificaciones[$i]["fecha_radicado"]; ?></td>			
				<td><?php echo $certificaciones[$i]["fecha_generado"]; ?></td>
				<td>
				<?php if ($certificaciones[$i]["estado"]==1){ ?>
						 <input id="chkNotifica" name="chkNotifica[]"  type="checkbox" value="<?php echo $certificaciones[$i]["id_certificado"]; ?>"/>		
				<?php } ?>
				</td>			
			</tr>
		<?php } ?>
	</tbody>
	</table>	
</div>
<div class="row">
	<div class="col-md-6">&nbsp;</div>
	<div class="col-md-6" style="text-align: right;">
		<?php if (count($certificaciones) > 0){ ?>
			<input type="button" id="btnMarcarTodos" name="btnMarcarTodos" value="Marcar Todos" class="btn btn-primary"/>
			<input type="button" id="btnNotificar" name="btnNotificar" value="Enviar Notificaciones" class="btn btn-primary"/>
		<?php } ?>
	</div>
</div>