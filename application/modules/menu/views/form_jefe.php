<script type="text/javascript" src="<?php echo base_url("js/gh_directorio/gh_directorio.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/menu/jefe.js"); ?>"></script>
<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="list-group-item-heading">
					ASIGNAR JEFE DE LA DEPENDENCIA
				</h4>
			</div>
		</div>	
	<div class="well">
            <form  name="formulario" id="formulario" role="form" method="post" >
                <input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $user["id"]; ?>"/>
                <div class="row">
                        <div class="form-group col-md-3">
                        <label for="txtIdentificacion">Nro. Identificaci&oacute;n</label>
                        <input type="text" id="txtIdentificacion" name="txtIdentificacion" value="<?php echo (isset($user["num_ident"]))?$user["num_ident"]:""; ?>" maxlength="12" class="form-control" placeholder="N&uacute;mero de C&eacute;dula" disabled>
                        </div>
                        <div class="form-group col-md-4">
                        <label for="txtNombres">Nombres</label>
                        <input type="text" id="txtNombres" name="txtNombres" value="<?php echo (isset($user["nom_usuario"]))?$user["nom_usuario"]:""; ?>" maxlength="50" class="form-control" placeholder="Nombres" disabled>
                        </div>
                        <div class="form-group col-md-4">
                        <label for="txtApellidos">Apellidos</label>
                        <input type="text" id="txtApellidos" name="txtApellidos" value="<?php echo (isset($user["ape_usuario"]))?$user["ape_usuario"]:""; ?>" maxlength="50" class="form-control" placeholder="Apellidos" disabled>
                        </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="cmbDespacho">Despacho : </label>
                        <select id="cmbDespacho" name="cmbDespacho" class="form-control" autocomplete="off"> 
                            <option value="">Seleccione...</option>
                            <?php
                            $idDespacho = substr($user["DEP_USUARIO"], 0, 1);
                            for ($i = 0; $i < count($despacho); $i++) {
                                ?>
                                <option value="<?php echo $despacho[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $despacho[$i]["id_dependencia"] == $idDespacho) { ?>selected="selected"<?php } ?>><?php echo $despacho[$i]["nom_dependencia"]; ?></option>	
                            <?php } ?>
                        </select>
                    </div>	
                    <div class="form-group col-md-4">
                        <label for="cmbdependencia">Dependencia : </label>
                        <select name="dependencia" id="dependencia" class="form-control" autocomplete="off">
                            <option value="">Seleccione...</option>
                            <?php
                            $idDendencia = substr($user["DEP_USUARIO"], 0, 2);
                            for ($i = 0; $i < count($dependencias); $i++) {
                                ?>
                                <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $dependencias[$i]["id_dependencia"] == $idDendencia) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>	
                            <?php } ?>													
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="grupo">Grupo : *</label>
                        <select name="grupo" id="grupo" class="form-control" autocomplete="off" >
                            <option value="">Seleccione...</option>
                            <?php for ($i = 0; $i < count($dependencias); $i++) { ?>
                                <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $dependencias[$i]["id_dependencia"] == $user["DEP_USUARIO"]) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>	
                            <?php } ?>												
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                            <label for="cargo">Cargo : *</label>
                            <select name="cargo" id="cargo" class="form-control" autocomplete="off">
                                    <option value='' >Seleccione...</option>
                                    <option value=1  >Director</option>
                                    <option value=2  >Jefe</option>
                                    <option value=3  >Coordinador</option>
                            </select>
                    </div>
                </div>
                <br>	
                <div class="row" align="center">
                    <div style="width:50%;" align="center">
                        <div id="div_cargando" style="display:none">		
                            <div class="progress progress-striped active">
                                <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                    <span class="sr-only">45% completado</span>
                                </div>
                            </div>
                        </div>	
                        <div id="div_guardado_academica" style="display:none">			
                            <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>
                        </div>	
                        <div id="div_error_academica" style="display:none">			
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                        </div>	
                        <input type="button" id="btnForm" name="btnForm" value="Guardar Datos" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
	</div>
    <div id="resultado"></div><!-- Carga lista -->
</div>