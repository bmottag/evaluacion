<script type="text/javascript" src="<?php echo base_url("js/login/actualizar.js"); ?>"></script>	
<script type="text/javascript" src="<?php echo base_url("js/gh_directorio/gh_directorio.js"); ?>"></script>	
<div class="container">
    <div class="panel panel-primary" style="margin-bottom: 10px; margin-top: 30px;">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">ACTUALIZAR DATOS</h4>
        </div>
    </div>
    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <form id="formulario" name="formulario" method="post" action="<?php echo site_url("/login/actualizarDatos"); ?>">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="txtIdentificacion">Nro. Identificaci&oacute;n</label>
                            <input type="text" id="txtIdentificacion" name="txtIdentificacion" value="<?php echo (isset($user["num_ident"])) ? $user["num_ident"] : ""; ?>" maxlength="12" class="form-control" placeholder="N&uacute;mero de C&eacute;dula" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtNombres">Nombres</label>
                            <input type="text" id="txtNombres" name="txtNombres" value="<?php echo (isset($user["nom_usuario"])) ? $user["nom_usuario"] : ""; ?>" maxlength="50" class="form-control" placeholder="Nombres" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtApellidos">Apellidos</label>
                            <input type="text" id="txtApellidos" name="txtApellidos" value="<?php echo (isset($user["ape_usuario"])) ? $user["ape_usuario"] : ""; ?>" maxlength="50" class="form-control" placeholder="Apellidos" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="txtTelefono">Tel&eacute;fono</label>
                            <input type="text" id="txtTelefono" name="txtTelefono" value="<?php echo (isset($user["tel_usuario"])) ? $user["tel_usuario"] : ""; ?>" maxlength="10" class="form-control" placeholder="Tel&eacute;fono"  autofocus>
                        </div>  
                        <div class="form-group col-md-2">
                            <label for="txtExtension">Extensi&oacute;n</label>
                            <input type="text" id="txtExtension" name="txtExtension" value="<?php echo (isset($user["ext_usuario"])) ? $user["ext_usuario"] : ""; ?>" maxlength="10" class="form-control" placeholder="Extensi&oacute;n" >
                        </div>  				
                        <div class="form-group col-md-6">
                            <label for="txtEmail">Correo Electr&oacute;nico</label>
                            <input type="text" id="txtEmail" name="txtEmail" value="<?php echo (isset($user["mail_usuario"])) ? $user["mail_usuario"] : ""; ?>" maxlength="100" class="form-control" placeholder="Correo Electr&oacute;nico DANE" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cmbDespacho">Despacho</label>
                            <select id="cmbDespacho" name="cmbDespacho" class="form-control" autocomplete="off"> 
                                <option value="">Seleccione...</option>
                                <?php
                                $idDespacho = substr($user["dep_usuario"], 0, 1);
                                for ($i = 0; $i < count($despacho); $i++) { ?>
                                    <option value="<?php echo $despacho[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $despacho[$i]["id_dependencia"] == $idDespacho) { ?>selected="selected"<?php } ?>><?php echo $despacho[$i]["nom_dependencia"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>	
                        <div class="form-group col-md-4">
                            <label for="cmbdependencia">Dependencia</label>
                            <select name="dependencia" id="dependencia" class="form-control" autocomplete="off">
                                <option value="-">Seleccione...</option>
                                <?php
                                $idDendencia = substr($user["dep_usuario"], 0, 2);
                                for ($i = 0; $i < count($dependencias); $i++) { ?>
                                    <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $dependencias[$i]["id_dependencia"] == $idDendencia) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="grupo">Grupo</label>
                            <select name="grupo" id="grupo" class="form-control" autocomplete="off" >
                                <option value="">Seleccione...</option>
                                <?php for ($i = 0; $i < count($dependencias); $i++) { ?>
                                    <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $dependencias[$i]["id_dependencia"] == $user["dep_usuario"]) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>	
                                <?php } ?>												
                            </select>
                        </div>						
                    </div>
                    <br/>
                    <div class="row">	  				
                        <div id="result" class="form-group col-md-12" style="text-align: center;">
                            <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary">Actualizar Datos</button>&nbsp;&nbsp;&nbsp;
                            <button type="button" id="btnCancelarActualizar" name="btnCancelarActualizar" class="btn btn-primary">Cancelar</button>
                        </div>
                    </div>
                    <input type="hidden" id="hddIDUsuario" name="hddIDUsuario" value="<?php echo (isset($user["id"])) ? $user["id"] : ""; ?>"/>
                    <input type="hidden" id="cmbTipoVinculacion" name="cmbTipoVinculacion" value="<?php echo (isset($user["tipov_usuario"])) ? $user["tipov_usuario"] : ""; ?>"/>
                    <input type="hidden" id="hddNombres" name="hddNombres" value="<?php echo (isset($user["nom_usuario"])) ? $user["nom_usuario"] : ""; ?>" >
                    <input type="hidden" id="hddApellidos" name="hddApellidos" value="<?php echo (isset($user["ape_usuario"])) ? $user["ape_usuario"] : ""; ?>" >
                </form>    		
            </div>
        </div>
    </div>
</div>