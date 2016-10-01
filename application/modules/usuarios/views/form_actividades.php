<?php 
    if($user["POLITICA"] != 1) {
?> 	
    <div class='alert alert-danger text-center'><strong>Atenci&oacute;n: </strong>Para diligenciar este formulario, debes aceptar el "Aviso de privacidad para la recolecci&oacute;n de datos personales" ubicado en el formulario "Datos Usuario".</div>
<?php } else { ?>
<script type="text/javascript" src="<?php echo base_url("js/usuarios/actividades.js"); ?>"></script>
<div class="container">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                ACTIVIDADES
            </h4>
        </div>
    </div>	
    <div class="well">
        <h3><strong>Registrar las actividades que hace fuera del ambiente laboral</strong></h3><br>
        <form  name="formActividades" id="formActividades" role="form" method="post" >
            <input type="hidden" id="hddIDActividad" name="hddIDActividad" value="<?php echo $infoActividades ? $infoActividades[0]["ID_ACTIVIDAD"] : ""; ?>"/>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="tipoLudica">Tipo l&uacute;dica: *</label>
                    <select name="tipoLudica" id="tipoLudica" class="form-control" autocomplete="off">
                        <option value='' >Seleccione...</option>
                        <?php for ($i = 0; $i < count($tipoLudica); $i++) { ?>
                            <option value="<?php echo $tipoLudica[$i]["TIPO_LUDICA"]; ?>" <?php if ($infoActividades && $tipoLudica[$i]["TIPO_LUDICA"] == $infoActividades[0]["TIPO_LUDICA"]) { ?>selected="selected"<?php } ?>><?php echo $tipoLudica[$i]["TIPO_LUDICA"]; ?></option>	
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="ludica">Actividad : *</label>
                    <select name="ludica" id="ludica" class="form-control" autocomplete="off" >
                        <option value="">Seleccione...</option>
                        <?php for ($i = 0; $i < count($ludica); $i++) { ?>
                            <option value="<?php echo $ludica[$i]["ID_LUDICA"]; ?>" <?php if ($infoActividades && $ludica[$i]["ID_LUDICA"] == $infoActividades[0]["FK_ID_LUDICA"]) { ?>selected="selected"<?php } ?>><?php echo $ludica[$i]["LUDICA"]; ?></option>	
                        <?php } ?>
                        <option value=99 <?php if ($infoActividades && 99 == $infoActividades[0]["FK_ID_LUDICA"]) { ?>selected="selected"<?php } ?>>Otra</option>	
                    </select>
                </div>
                <?php
                $mostrar = 'style="display: none;"';
                if (99 == $infoActividades[0]["FK_ID_LUDICA"]) {
                    $mostrar = '';
                }
                ?>
                <div class="form-group col-md-2" id="mostrarCual" <?php echo $mostrar; ?> >
                    <label class="control-label">Cu&aacute;l</label>
                    <input type="text" id="cual" name="cual" value="<?php echo $infoActividades ? $infoActividades[0]["CUAL"] : ""; ?>" class="form-control" placeholder="Cu&aacute;l" maxlength="30" required >
                </div>
                <div class="form-group col-md-4">
                    <label for="horas">Número de horas al mes que lo practica: *</label>
                    <input type="text" id="horas" name="horas" value="<?php echo $infoActividades ? $infoActividades[0]["HORAS"] : ""; ?>" class="form-control" placeholder="Horas al mes" required >
                </div>
            </div>
            <br>
            
            <div class="alert alert-info">
                <h5 style="text-align: center;">Una vez diligenciada la información, podras continuar con el formulario de "Mascotas".
                </h5>
            </div>
            
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
                    <div id="div_guardado_academica" style="display:none">			
                        <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>
                    </div>	
                    <div id="div_error_academica" style="display:none">			
                        <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                    </div>	
                    <input type="button" id="btnActividad" name="btnActividad" value="Guardar Datos" class="btn btn-primary"/>
                </div>
            </div>
        </form>
    </div>
    <div id="resultado"></div><!-- Carga lista -->
</div>
<?php } ?>