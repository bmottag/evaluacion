<script type="text/javascript" src="<?php echo base_url("js/gh_directorio/gh_directorio.js"); ?>"></script>	
<script >
    $(function () {
        $("#correo").bloquearNumeros().maxlength(30);
        $("#nombre").bloquearNumeros().maxlength(50);
        $("#apellido").bloquearNumeros().maxlength(50);

        $("#nombre").autocomplete({
            source: base_url + "gh_directorio/get_autocomplete"
        });

        $("#apellido").autocomplete({
            source: base_url + "gh_directorio/get_autoApellido"
        });

    });
</script>	
<div class="container">
    <div class="page-header">
        <div class="panel panel-primary" style="margin-bottom: 10px; ">
            <div class="panel-heading">
                <h4 class="list-group-item-heading">
                    Seleccionar una o varias de las siguientes opciones para su consulta
                </h4>
            </div>
        </div>		
    </div>
    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <form id="formulario" name="formulario" method="post" action="<?php echo site_url("/gh_directorio/directorio"); ?>">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="txtNombres">Correo</label><br />
                            <input type="text" id="correo" name="correo" maxlength="50" class="form-control" style="display:inline; width: 50%" placeholder="Correo" autofocus />@dane.gov.co
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtNombres">Nombres</label>
                            <input type="text" id="nombre" name="nombre" maxlength="50" class="form-control" placeholder="Nombres" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtApellidos">Apellidos</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Apellidos" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cmbDespacho">Despacho</label>
                            <select id="cmbDespacho" name="cmbDespacho" class="form-control" autocomplete="off"> 
                                <option value="-">Seleccione...</option>
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
                            <select name="grupo" id="grupo" class="form-control" autocomplete="off">
                                <option value="">Seleccione...</option>
                                <?php for ($i = 0; $i < count($dependencias); $i++) { ?>
                                    <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $dependencias[$i]["id_dependencia"] == $user["dep_usuario"]) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>	
                                <?php } ?>												
                            </select>
                        </div>						
                    </div>
                    <br/> 			
                    <div class="row" align="center">
                        <div style="width:50%;" align="center">
                            <div id="div_cargando" style="display:none">		
                                <div class="progress progress-striped active">
                                    <div class="progress-bar" role="progressbar"
                                         aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 45%">
                                        <span class="sr-only">45% completado</span>
                                    </div>
                                </div>
                            </div>	
                            <div id="div_guardado" style="display:none">			
                                <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>
                            </div>	
                            <div id="div_error" style="display:none">			
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                            </div>	
                            <input type="submit" id="btnGuardar" name="btnGuardar" value="Buscar" class="btn btn-primary"/>
                        </div>
                    </div>	
                </form>    		
            </div>
        </div>
    </div>
</div>