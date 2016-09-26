<script type="text/javascript" src="<?php echo base_url("js/gh_asistencia/gh_registro.js"); ?>"></script>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                CONTROL DE ASISTENCIA
            </h4>
        </div>
    </div>
    <?php if($IPValida) {
        $msgError = (empty($msgError)) ? $this->session->flashdata('msgError'): $msgError;
        $msgSuccess = (empty($msgSuccess)) ? $this->session->flashdata('msgSuccess'): $msgSuccess;
    ?>
    <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"':'style="text-align: center;"';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgSuccess" style="font-size: x-large;"><?=$msgSuccess?></strong>
    </div>
    <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"':'style="text-align: center;"';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgError" style="font-size: x-large"><?=$msgError?></strong>
    </div>
    
    <div class="well">
        <form  name="frmAsistencia" id="frmAsistencia" enctype="multipart/form-data" role="form" method="post" action="<?php echo site_url("/gh_asistencia"); ?>">
            <div class="row">
                <div class="col-md-4 text-center"></div>
                <div class="col-md-4 text-center">
                    <input type="password" class="form-control" name="codigoBarras" id="codigoBarras" maxlength="12" 
                           placeholder="Codigo de barras" size="12" required autofocus />
                </div>
                <div class="col-md-4 text-center"></div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <br/>
                    <input type="button" id="btnRegistrar" name="btnRegistrar" value="Registrar" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
    <div id="divMsgPerfetti" class="alert alert-success" <?php echo (strlen($msgPerfetti) == 0) ? 'style="display: none;"':'style="text-align: center;"';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgPerfetti" style="font-size: x-large;"><?=$msgPerfetti?></strong>
    </div>
    <?php } else { ?>
    <div id="divMsgIPInvalida" class="alert alert-danger" style="text-align: center;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgIPInvalida" style="font-size: x-large"><?=$msgError?></strong>
    </div>
    <?php } ?>
</div>