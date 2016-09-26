<?php
if ($user["POLITICA"] != 1) {
    ?> 	
    <div class='alert alert-danger text-center'><strong>Atenci&oacute;n: </strong>Para diligenciar este formulario, debes aceptar el "Aviso de privacidad para la recolecci&oacute;n de datos personales" ubicado en el formulario "Datos Usuario".</div>
<?php } else { ?>
    <script type="text/javascript" src="<?php echo base_url("js/usuarios/academica.js"); ?>"></script>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="list-group-item-heading">
                    INFORMACI&Oacute;N ACAD&Eacute;MICA
                </h4>
            </div>
        </div>	
        <div class="well">
            <form  name="formAcademica" id="formAcademica" role="form" method="post" >
                <h3><strong>Registrar su informaci&oacute;n acad&eacute;mica</strong></h3><br>
                <input type="hidden" id="hddIDAcademica" name="hddIDAcademica" value="<?php echo $infoAcademica ? $infoAcademica[0]["ID_ACADEMICA"] : ""; ?>"/>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="nivelEstudio">Nivel de Estudios: *</label>
                        <select name="nivelEstudio" id="nivelEstudio" class="form-control" autocomplete="off">
                            <option value='' >Seleccione...</option>
                            <?php for ($i = 0; $i < count($nivelEstudio); $i++) { ?>
                                <option value="<?php echo $nivelEstudio[$i]["ID_ESTUDIO"]; ?>" <?php if ($infoAcademica && $nivelEstudio[$i]["ID_ESTUDIO"] == $infoAcademica[0]["FK_ID_ESTUDIO"]) { ?>selected="selected"<?php } ?>><?php echo $nivelEstudio[$i]["NIVEL_ESTUDIO"]; ?></option>	
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tituloEstudio">T&iacute;tulo : * </label>
                        <input type="text" id="tituloEstudio" name="tituloEstudio" value="<?php echo $infoAcademica ? $infoAcademica[0]["TITULO"] : ""; ?>" class="form-control" placeholder="T&iacute;tulo" required >
                    </div>
                </div>
                <?php
                $mostrar = 'style="display: none;"';
                if (99 != $infoAcademica[0]["ID_ESTUDIO"]) {
                    $mostrar = '';
                }
                ?>
                <div class="row" id="mostrar" <?php echo $mostrar; ?>>
                    <div class="form-group col-md-6">
                        <label for="areaConocimmiento">&Aacute;rea de conocimiento : </label>
                        <select name="areaConocimmiento" id="areaConocimmiento" class="form-control" autocomplete="off" required >
                            <option value='' >Seleccione...</option>
                            <?php for ($i = 0; $i < count($areaConocimmiento); $i++) { ?>
                                <option value="<?php echo $areaConocimmiento[$i]["ID_AREA"]; ?>" <?php if ($infoAcademica && $areaConocimmiento[$i]["ID_AREA"] == $infoAcademica[0]["FK_ID_AREA"]) { ?>selected="selected"<?php } ?>><?php echo $areaConocimmiento[$i]["AREA_CONOCIMIENTO"]; ?></option>	
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="graduado">Graduado? : </label>
                        <select name="graduado" id="graduado" class="form-control" autocomplete="off" required >
                            <option value='' >Seleccione...</option>
                            <option value=1 <?php if (1 == $infoAcademica[0]["GRADUADO"]) { ?>selected="selected"<?php } ?> >Si</option>
                            <option value=2 <?php if (2 == $infoAcademica[0]["GRADUADO"]) { ?>selected="selected"<?php } ?> >No</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2" id="anno" <?php echo ($infoAcademica[0]["GRADUADO"] == 2) ? 'style="display: none;"' : ''; ?>>
                        <label for="annoEstudio">A&ntilde;o Finalizaci&oacute;n : </label>
                        <select name="annoEstudio" id="annoEstudio" class="form-control" required>
                            <option value='' >Seleccione...</option>
                            <?php
                            $annoActual = date('Y');
                            for ($i = $annoActual; $i > 1970; $i--) {
                                ?>
                                <option value='<?php echo $i; ?>' <?php
                                if ($infoAcademica && $i == $infoAcademica[0]["ANNO"]) {
                                    echo 'selected="selected"';
                                }
                                ?>><?php echo $i; ?></option>
                                    <?php } ?>									
                        </select>
                    </div>
                </div>
                <br>

                <div class="alert alert-info">
                    <h5 style="text-align: center;">Una vez diligenciada la información, podras continuar con el formulario de "Idiomas".
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
                        <?php
                        if ($btnGuardarAcad == 'SI') {
                            echo '<input type="button" id="btnAcademica" name="btnAcademica" value="Guardar Datos" class="btn btn-primary"/>';
                        } else if ($btnGuardarAcad == 'NO') {
                            echo "<div class='alert alert-warning'><strong>Atenci&oacute;n : </strong>No puede ingresar mas datos porque registro la opci&oacute;n ninguno.</div>";
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
        <div id="resultado"></div><!-- Carga lista -->
    </div>
<?php } ?>