<script type="text/javascript" src="<?php echo base_url("js/menu/lista_usuario.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/gh_directorio/gh_directorio.js"); ?>"></script>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                USUARIOS
            </h4>
        </div>
    </div>
    
    <div class="well">
        <form  name="frmPersonasAsis" id="frmPersonasAsis" enctype="multipart/form-data" role="form" method="post">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="cmbDespacho">Despacho : *</label>
                    <select id="cmbDespacho" name="cmbDespacho" class="form-control" autocomplete="off"> 
                        <option value="-">Seleccione...</option>
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
                        <option value="-">Seleccione...</option>
                        <?php
                        $idDendencia = substr($user["DEP_USUARIO"], 0, 2);
                        for ($i = 0; $i < count($dependencias); $i++) {
                            ?>
                            <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $dependencias[$i]["id_dependencia"] == $idDendencia) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>	
                        <?php } ?>													
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="grupo">Grupo : </label>
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
                    <label for="txtDocu">Cedula</label>
                    <input type="text" id="txtDocu" name="txtDocu" value="" maxlength="11" class="form-control" placeholder="N&uacute;mero de documento" autofocus />
                </div>
                <div class="form-group col-md-4">
                    <label for="txtNombres">Nombre(s)</label>
                    <input type="text" id="txtNombres" name="txtNombres" value="" maxlength="100" class="form-control" placeholder="Nombre(s)" />
                </div>
                <div class="form-group col-md-4">
                    <label for="txtApellidos">Apellido(s)</label>
                    <input type="text" id="txtApellidos" name="txtApellidos" value="" maxlength="100" class="form-control" placeholder="Apellidos(s)" />
                </div>
            </div>
            <div class="row" align="center">
                <div style="width: 50%;" align="center">
                    <button type="button" class="btn btn-info" id="btnBuscar" name="btnBuscar"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button>
                </div>
            </div>
        </form>
        <br />
        <div class="centergrid">
            <table id="listPersonasAsis"></table>
            <div id="pagerPersonasAsis"></div>
        </div>
    </div>
</div>