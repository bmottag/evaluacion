<script type="text/javascript" src="<?php echo base_url("js/gh_asistencia/gh_editar_asistencia.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/general/jquery-ui-timepicker-addon.js"); ?>"></script>
<link href="<?php echo base_url("/css/jquery-ui-timepicker-addon.css"); ?>" rel="stylesheet"/>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">ADICIONAR ASISTENCIA</h4>
        </div>
    </div>
    <?php
    $msgError = (empty($msgError)) ? $this->session->flashdata('msgError'): $msgError;
    $msgSuccess = (empty($msgSuccess)) ? $this->session->flashdata('msgSuccess'): $msgSuccess;
    ?>
    <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"':'';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgSuccess"><?=$msgSuccess?></strong>
    </div>
    <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"':'';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgError"><?=$msgError?></strong>
    </div>
    <div class="well">
        <form  name="frmAsistencia" id="frmAsistencia" enctype="multipart/form-data" role="form" method="post" action="<?php echo site_url("/gh_asistencia/editarAsistencia"); ?>">
            <div class="row">
                <div class="col-md-3 text-center"></div>
                <div class="col-md-4 text-center">
                    <label for="numeDocu" class="control-label">N&uacute;mero de documento: *</label>
                    <input type="text" class="form-control" name="numeDocu" id="numeDocu" maxlength="13" 
                           placeholder="Número de documento" size="13" required autofocus />
                </div>
                <div class="col-md-2 text-center">
                    <label for="txtHora">Hora</label>
                    <input type="text" id="hora" name="hora" class="form-control timepicker-jq" placeholder="00:00" value="<?=$hora?>" maxlength="5" required />
                </div>
                <div class="col-md-3 text-center"></div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <br/>
                    <input type="button" id="btnGuardar" name="btnGuardar" value="Guardar" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</div>