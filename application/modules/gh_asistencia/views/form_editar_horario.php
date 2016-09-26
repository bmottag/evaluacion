<script type="text/javascript" src="<?php echo base_url("js/gh_asistencia/gh_horario.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/general/jquery-ui-timepicker-addon.js"); ?>"></script>
<link href="<?php echo base_url("/css/jquery-ui-timepicker-addon.css"); ?>" rel="stylesheet"/>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                DATOS HORARIO
            </h4>
        </div>
    </div>
    <?php
    $msgError = (empty($msgError)) ? $this->session->flashdata('msgError'): $msgError;
    $msgSuccess = (empty($msgSuccess)) ? $this->session->flashdata('msgSuccess'): $msgSuccess;
    ?>
    <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgSuccess"><?= $msgSuccess ?></strong>
    </div>
    <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgError"><?= $msgError ?></strong>
    </div>
    <div class="well">
        <form name="frmHorario" id="frmHorario" role="form" method="post" enctype="multipart/form-data" action="">
            <input type="hidden" name="idPers" id="idPers" value="<?=$idPers?>" />
            <input type="hidden" name="idHorario" id="idHorario" value="<?=$horario["ID_HORARIO"]?>" />
            <div class="row">
                <div class="form-group col-md-12 alert alert-info" style="padding: 0; text-align: center;">
                    <label for="txtPers" style="margin-top: 10px;"><h4><?=$nombre . ' - ' . $nume_docu?></h4></label>
                </div>    
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtResolucion">Resolución *</label>
                </div>
                <div class="form-group col-md-3">
                    <label for="txtNumeroReso">Número</label>
                    <input type="text" id="txtNumeroReso" name="txtNumeroReso" value="<?=$horario["NUME_RESO"]?>" class="form-control" placeholder="Número" />
                </div>
                <div class="form-group col-md-4">
                    <label for="txtFechaReso">Fecha</label>
                    <input type="text" id="txtFechaReso" name="txtFechaReso" value="<?=$horario["FECHA_RESOLU"]?>" class="form-control" placeholder="dd/mm/yyyy" readonly />
                </div>
                <div class="form-group col-md-3">
                    <label for="txtFechaReso">Archivo</label>
                    <?php if(!empty($horario["RUTA_RESO"])) {
                        echo '<br /><a href="' . $horario["RUTA_RESO"] . '" target="_blank"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;Ver</a>&nbsp;';
                    } ?>
                    <input type="file" id="fileReso" name="fileReso" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2"></div>
                <div class="col-md-5">
                    <div id="alertNumeroReso" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
                <div class="col-md-5">
                    <div id="alertFechaReso" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtResolucion">Fecha *</label>
                </div>
                <div class="form-group col-md-5">
                    <label for="txtFechaInicial">Inicial</label>
                    <input type="text" id="txtFechaInicial" name="txtFechaInicial" value="<?=$horario["FECHA_INI"]?>" class="form-control" placeholder="dd/mm/yyyy" readonly />
                </div>
                <div class="form-group col-md-5">
                    <label for="txtFechaFinal">Final</label>
                    <input type="text" id="txtFechaFinal" name="txtFechaFinal" value="<?=$horario["FECHA_FIN"]?>" class="form-control" placeholder="dd/mm/yyyy" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2"></div>
                <div class="col-md-5">
                    <div id="alertFechaInicial" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
                <div class="col-md-5">
                    <div id="alertFechaFinal" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtLunes">Lunes *</label>
                </div>
                <div class="form-group col-md-5">
                    <label for="txtEntradaL">Entrada</label>
                    <input type="text" id="txtEntradaL" name="txtEntradaL" value="<?=$horario["ENTRADA_L"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
                <div class="form-group col-md-5">
                    <label for="txtSalidaL">Salida</label>
                    <input type="text" id="txtSalidaL" name="txtSalidaL" value="<?=$horario["SALIDA_L"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2"></div>
                <div class="col-md-5">
                    <div id="alertEntradaL" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
                <div class="col-md-5">
                    <div id="alertSalidaL" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtMartes">Martes *</label>
                </div>
                <div class="form-group col-md-5">
                    <label for="txtEntradaM">Entrada</label>
                    <input type="text" id="txtEntradaM" name="txtEntradaM" value="<?=$horario["ENTRADA_M"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
                <div class="form-group col-md-5">
                    <label for="txtSalidaM">Salida</label>
                    <input type="text" id="txtSalidaM" name="txtSalidaM" value="<?=$horario["SALIDA_M"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2"></div>
                <div class="col-md-5">
                    <div id="alertEntradaM" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
                <div class="col-md-5">
                    <div id="alertSalidaM" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtMiercoles">Miércoles *</label>
                </div>
                <div class="form-group col-md-5">
                    <label for="txtEntradaX">Entrada</label>
                    <input type="text" id="txtEntradaX" name="txtEntradaX" value="<?=$horario["ENTRADA_X"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
                <div class="form-group col-md-5">
                    <label for="txtSalidaX">Salida</label>
                    <input type="text" id="txtSalidaX" name="txtSalidaX" value="<?=$horario["SALIDA_X"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2"></div>
                <div class="col-md-5">
                    <div id="alertEntradaX" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
                <div class="col-md-5">
                    <div id="alertSalidaX" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtJueves">Jueves *</label>
                </div>
                <div class="form-group col-md-5">
                    <label for="txtEntradaJ">Entrada</label>
                    <input type="text" id="txtEntradaJ" name="txtEntradaJ" value="<?=$horario["ENTRADA_J"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
                <div class="form-group col-md-5">
                    <label for="txtSalidaL">Salida</label>
                    <input type="text" id="txtSalidaJ" name="txtSalidaJ" value="<?=$horario["SALIDA_J"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2"></div>
                <div class="col-md-5">
                    <div id="alertEntradaJ" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
                <div class="col-md-5">
                    <div id="alertSalidaJ" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtViernes">Viernes *</label>
                </div>
                <div class="form-group col-md-5">
                    <label for="txtEntradaV">Entrada</label>
                    <input type="text" id="txtEntradaV" name="txtEntradaV" value="<?=$horario["ENTRADA_V"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
                <div class="form-group col-md-5">
                    <label for="txtSalidaL">Salida</label>
                    <input type="text" id="txtSalidaV" name="txtSalidaV" value="<?=$horario["SALIDA_V"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2"></div>
                <div class="col-md-5">
                    <div id="alertEntradaV" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
                <div class="col-md-5">
                    <div id="alertSalidaV" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtSabado">Sábado</label>
                </div>
                <div class="form-group col-md-5">
                    <label for="txtEntradaS">Entrada</label>
                    <input type="text" id="txtEntradaS" name="txtEntradaS" value="<?=$horario["ENTRADA_S"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
                <div class="form-group col-md-5">
                    <label for="txtSalidaL">Salida</label>
                    <input type="text" id="txtSalidaS" name="txtSalidaS" value="<?=$horario["SALIDA_S"]?>" class="form-control timepicker-jq" placeholder="00:00" readonly />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2"></div>
                <div class="col-md-5">
                    <div id="alertEntradaS" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
                <div class="col-md-5">
                    <div id="alertSalidaS" class="alert alert-warning" role="alert" style="display: none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <br/>
                    <?php if($horario["ID_HORARIO"] > 0) {
                            echo '<input type="button" id="btnActualizar" name="btnActualizar" value="Actualizar" class="btn btn-primary" />';
                        } else {
                            echo '<input type="button" id="btnGuardar" name="btnGuardar" value="Guardar" class="btn btn-primary" />';
                        }
                    ?>
                    &nbsp;&nbsp;&nbsp;<input type="button" id="btnRegresar" name="btnRegresar" value="Regresar" class="btn btn-info" />
                </div>
            </div>
        </form>
    </div>
</div>