<script type="text/javascript" src="<?php echo base_url("js/login/login.js"); ?>"></script>	
<script type="text/javascript" src="<?php echo base_url("js/gh_directorio/gh_directorio.js"); ?>"></script>	
<div class="container">
    <div class="panel panel-primary" style="margin-bottom: 10px; margin-top: 30px;">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">CREACI&Oacute;N DE USUARIOS</h4>
        </div>
    </div>
    <div class="well">
        <form id="formulario" name="formulario" method="post" action="<?php echo site_url("/login/crearUsuario"); ?>">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="txtIdentificacion">Nro. Identificaci&oacute;n</label>
                    <input type="text" id="txtIdentificacion" name="txtIdentificacion" value="<?php echo (isset($user["num_ident"])) ? $user["num_ident"] : ""; ?>" class="form-control" placeholder="N&uacute;mero de C&eacute;dula" autofocus />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtTelefono">Tel&eacute;fono</label>
                    <input type="text" id="txtTelefono" name="txtTelefono" value="<?php echo (isset($user["tel_usuario"])) ? $user["tel_usuario"] : ""; ?>" class="form-control" placeholder="Tel&eacute;fono" />
                </div>  
                <div class="form-group col-md-2">
                    <label for="txtNewExtension">Extensi&oacute;n</label>
                    <input type="text" id="txtExtension" name="txtExtension" value="<?php echo (isset($user["ext_usuario"])) ? $user["ext_usuario"] : ""; ?>" class="form-control" placeholder="Extensi&oacute;n" />
                </div>  				
                <div class="form-group col-md-4">
                    <label for="txtEmail">Correo Electr&oacute;nico DANE</label><br />
                    <input type="text" id="txtEmail" name="txtEmail" value="<?php echo (isset($user["mail_usuario"])) ? $user["mail_usuario"] : ""; ?>" class="form-control" 
                        style="display: inline; width: 50%;" placeholder="Correo Electr&oacute;nico DANE" required />@dane.gov.co
                </div>
                <div class="form-group col-md-4"></div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="cmbDespacho">Despacho</label>
                    <select id="cmbDespacho" name="cmbDespacho" class="form-control" autocomplete="off"> 
                        <option value="">Seleccione...</option>
                        <?php for ($i = 0; $i < count($despacho); $i++) { ?>
                            <option value="<?php echo $despacho[$i]["id_dependencia"]; ?>" ><?php echo $despacho[$i]["nom_dependencia"]; ?></option>	
                        <?php } ?>
                    </select>
                </div>	
                <div class="form-group col-md-4">
                    <label for="dependencia">Dependencia</label>
                    <select name="dependencia" id="dependencia" class="form-control" autocomplete="off">
                        <option value="-">Seleccione...</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="grupo">Grupo</label>
                    <select name="grupo" id="grupo" class="form-control" autocomplete="off" >
                        <option value="">Seleccione...</option>
                    </select>
                </div>
            </div>
            <br/>
            <div class="row">
                <div id="result" class="form-group col-md-12" style="text-align: center;">
                    <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-primary">Guardar</button>&nbsp;&nbsp;&nbsp;
                    <button type="button" id="btnCrearCancelar" name="btnCrearCancelar" class="btn btn-primary">Cancelar</button>
                </div>
            </div>
            <input type="hidden" id="hddIDUsuario" name="hddIDUsuario" value="<?php echo (isset($user["id_usuario"])) ? $user["id_usuario"] : ""; ?>"/>	
        </form>
    </div>
</div>