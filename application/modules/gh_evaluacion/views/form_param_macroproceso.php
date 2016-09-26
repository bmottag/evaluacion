<script type="text/javascript" src="<?php echo base_url("js/gh_evaluacion/macroproceso.js"); ?>"></script>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                ADICIONAR/EDITAR MACROPROCESOS
            </h4>
        </div>
    </div>
		<div class="alert alert-info" role="alert">
			<strong>Formulario </strong> para adicionar y editar macroprocesos y asignar el jefe que va a realizar el seguimiento.
		</div>	
    <div class="well">
        <form  name="formulario" id="formulario" role="form" method="post" >
            <input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $informacion ? $informacion[0]["ID_MACROPROCESO"] : ""; ?>"/>
            <div class="row">
                <div class='col-md-2'>
                    <label class="control-label">Área : *</label>
                    <select name="area" id="area" class="form-control" >
                        <option value='' >Seleccione...</option>
                        <?php for ($i = 0; $i < count($area); $i++) { ?>
                            <option value="<?php echo $area[$i]["ID_AREA"]; ?>" <?php if ($informacion && $area[$i]["ID_AREA"] == $informacion[0]["FK_ID_AREA"]) { ?>selected="selected"<?php } ?>><?php echo $area[$i]["AREA"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Nombre Macroproceso : *</label>
                    <input type="text" id="macroproceso" name="macroproceso" value="<?php echo $informacion ? $informacion[0]["MACROPROCESO"] : ""; ?>" class="form-control" placeholder="Macroproceso" required >
                </div>
                <div class="col-md-4">
                    <label class="control-label">Jefe: *</label>
                    <select name="jefe" id="jefe" class="form-control" autocomplete="off">
                        <option value='' >Seleccione...</option>
                        <?php for ($i = 0; $i < count($usuariosPlanta); $i++) { ?>
                            <option value="<?php echo $usuariosPlanta[$i]->FK_ID_USUARIO; ?>" <?php if ($informacion && $usuariosPlanta[$i]->FK_ID_USUARIO == $informacion[0]["FK_ID_USUARIO"]) { ?>selected="selected"<?php } ?>><?php echo $usuariosPlanta[$i]->JEFE; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class='col-md-2'>
                    <label class="control-label">Estado: *</label>
                    <select name="estado" id="estado" class="form-control" >
                        <option value='' >Seleccione...</option>
                        <option value='1' <? if($informacion[0]["ESTADO"] == '1') { echo "selected "; }  ?>>Activo</option>
                        <option value='2' <? if($informacion[0]["ESTADO"] == '2') { echo "selected "; }  ?>>Bloqueado</option>
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