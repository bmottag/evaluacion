<script src="<?php echo base_url("js/admin/ghumana/certificados.js"); ?>"></script>
<h3>Solicitudes de Certificaciones</h3>
<div class="row">	
	<div class="col-md-2">		
		<input type="text" id="txtBuscarCertificado" name="txtBuscarCertificado" value="<?php echo (isset($user["num_ident"]))?$user["num_ident"]:""; ?>" class="form-control" placeholder="Num. Identificaci&oacute;n" required autofocus>
	</div>
	<div class="col-md-10">	
		<input type="button" id="btnBuscarCertificados" name="btnBuscarCertificados" value="Buscar" class="btn btn-primary"/>
	</div>	
</div>
<div id="certificaciones">
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
		<div class="col-md-6"><?php echo $links; ?></div>
		<div class="col-md-6" style="text-align: right;">
			<input type="button" id="btnMarcarTodos" name="btnMarcarTodos" value="Marcar Todos" class="btn btn-primary"/>
			<input type="button" id="btnNotificar" name="btnNotificar" value="Enviar Notificaciones" class="btn btn-primary"/>
		</div>
	</div>	
</div>
<div class="row">
	<div id="ajxresult" class="col-md-12"></div>
</div>
<br/>
