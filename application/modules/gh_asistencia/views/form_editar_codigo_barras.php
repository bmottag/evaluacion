<script type="text/javascript" src="<?php echo base_url("js/gh_asistencia/gh_codigo_barras.js"); ?>"></script>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                DATOS USUARIO
            </h4>
        </div>
    </div>
    <?php
    //$msgError = (empty($msgError)) ? $this->session->flashdata('msgError'): $msgError;
    //$msgSuccess = (empty($msgSuccess)) ? $this->session->flashdata('msgSuccess'): $msgSuccess;
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
        <form  name="frmUsuario" id="frmUsuario" role="form" method="post" enctype="multipart/form-data" action="<?php echo base_url("gh_asistencia/editarCodigoBarra/"); ?>">
            <input type="hidden" name="idPers" id="idPers" value="<?=$idPers?>" />
            <input type="hidden" name="codigoBarras" id="codigoBarras" value="<?=$codigoBarras?>" />
            <input type="hidden" name="codigoBarras8" id="codigoBarras8" value="<?=$codigoBarras8?>" />
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtIdentificacion">No. Identificaci&oacute;n</label>
                    <input type="text" id="txtIdentificacion" name="txtIdentificacion" value="<?=$nume_docu?>" class="form-control" placeholder="N&uacute;mero de c&eacute;dula" disabled="disabled" />
                </div>
                <div class="form-group col-md-4">
                    <label for="txtNombres">Nombres</label>
                    <input type="text" id="txtNombres" name="txtNombres" value="<?=$nombres?>" class="form-control" placeholder="Nombres" disabled="disabled" />
                </div>
                <div class="form-group col-md-4">
                    <label for="txtApellidos">Apellidos</label>
                    <input type="text" id="txtApellidos" name="txtApellidos" value="<?=$apellidos?>" class="form-control" placeholder="Apellidos" disabled="disabled" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtNombres">Correo electrónico</label>
                    <input type="text" id="txtEmail" name="txtEmail" value="<?=$email?>" class="form-control" placeholder="Correo electrónico" disabled="disabled" />
                </div>
                <div class="form-group col-md-4">
                    <label for="txtApellidos">Apellidos</label>
                    <input type="text" id="txtUsuario" name="txtUsuario" value="<?=$usuario?>" class="form-control" placeholder="Usuario" disabled="disabled" />
                </div>
                <div class="form-group col-md-4"></div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtCodigoBarras">Código de barras</label>
                </div>
                <div class="form-group col-md-8">
                    <a href="<?=base_url('gh_asistencia/descargarCodigoBarras/' . $idPers)?>" target="_blank">
                        <img src="<?=$imagenCB?>" title="Click sobre la imagen para imprimir" />
                    </a>
                    <?php if(!empty($codigoBarras)) {
                        if($existeCB == 'SI') { ?>
                            &nbsp;&nbsp;&nbsp;
                            <a href="<?=base_url('gh_asistencia/descargarCodigoBarras/' . $idPers)?>" target="_blank">Descargar</a>
                    <?php } }?>
                    &nbsp;&nbsp;&nbsp;
                    <a href="<?=base_url('gh_asistencia/descargarCodigoBarras8/' . $idPers)?>" target="_blank">Descargar EAN8</a>
                </div>
                <div class="form-group col-md-2"></div>
            </div>
            <?php if($existeCB == 'SI') { ?>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="txtCodigoBarras">Recuerde que si va a imprimir el código de barras preferiblemente que la impresora sea a laser y que tenga suficiente toner para que la imagen sea nítida y el lector de código de 
                        barras lea el código de barras correctamente.</label>
                </div>
            </div>
            <?php } else { ?>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="txtCodigoBarras">La persona seleccionada no tiene asociado el código de barras, se recomienda guardar para asignar el código de barras indicado a continuación a la persona:</label>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <br/>
                    <?php if(!empty($codigoBarras)) {
                        if($existeCB == 'SI') {
                            echo '<input type="hidden" id="opc" name="opc" value="u" />';
                            echo '<input type="button" id="btnActualizar" name="btnActualizar" value="Actualizar" class="btn btn-primary" />';
                        } else {
                            echo '<input type="hidden" id="opc" name="opc" value="c" />';
                            echo '<input type="button" id="btnGuardar" name="btnGuardar" value="Guardar" class="btn btn-primary" />';
                        }
                    }
                    ?>
                    &nbsp;&nbsp;&nbsp;<input type="button" id="btnRegresar" name="btnRegresar" value="Regresar" class="btn btn-info" />
                </div>
            </div>
        </form>        
    </div>
</div>