<div class="container">
    <div class="page-header">
        <h2><?= $titulo ?></h2>
    </div>
    <div class="row" align="center">
        <div style="width: 50%;" align="center">
            <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"' : ''; ?>>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong id="msgSuccess"><?= $msgSuccess ?></strong>
            </div>
            <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"' : ''; ?>>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong id="msgError"><?= $msgError ?></strong>
            </div>
        </div>
        <?php if(strlen($msgSuccess) > 0) {?>
        <div style="width: 50%;" align="center">
            <input type="button" id="btnVer" name="btnVer" value="Ver estado del permiso" class="btn btn-info"
                   onclick="window.location.href='<?=base_url("gh_solicitudpermiso/estado_permisos/$idRegistro")?>'"/>
        </div>
        <?php } ?>
    </div>
</div>