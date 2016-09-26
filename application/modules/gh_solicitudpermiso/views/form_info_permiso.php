<div class="container" style="width: 100%">
    <form  name="frmPermiso" id="frmPermiso" enctype="multipart/form-data" role="form" method="post" action="">
        <div class="row">
            <div class="col-md-3"><label class="control-label">Permiso No.</label></div>
            <div class="col-md-3"><?=$permiso['ID_SOLICITUD']?></div>
            <div class="col-md-3"><label class="control-label">Fecha solicitud</label></div>
            <div class="col-md-3"><?=$permiso['FECHA_SOLICITUD']?></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="control-label">Tipo</label></div>
            <div class="col-md-3"><?=$permiso["TIPO"]?></div>
            <div class="col-md-3"><label class="control-label">Estado</label></div>
            <div class="col-md-3"><span class="label <?=$permiso["CLASE"]?>"><?=$permiso["ESTADO"]?></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label class="control-label">Motivo</label></div>
            <div class="col-md-9">
                <?echo $permiso["MOTIVO"];
                if(!empty($permiso["SUBMOTIVO"])) {
                    echo " - " . $permiso["SUBMOTIVO"];
                }
                ?>
            </div>
        </div>
        <?php if(!empty($permiso["FK_ID_TIPO"])) {
            switch ($permiso["FK_ID_TIPO"]) {
                case '1':
                    echo '<div class="row">
                        <div class="col-md-3"><label class="control-label">Fecha permiso</label></div>
                        <div class="col-md-9">' . completar_fecha($permiso["FECHA_INI"]) . '</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><label class="control-label">Hora inicio</label></div>
                        <div class="col-md-3">' . $permiso["HORA_INICIO"] . '</div>
                        <div class="col-md-3"><label class="control-label">Hora final</label></div>
                        <div class="col-md-3">' . $permiso["HORA_FIN"] . '</div>
                    </div>';
                    break;
                case '2':
                    echo '<div class="row">
                        <div class="col-md-3"><label class="control-label">Fecha permiso</label></div>
                        <div class="col-md-9">' . $permiso["FECHA_INI"] . '</div>
                    </div>';
                    break;
                case '3':
                case '4':
                    echo '<div class="row">
                        <div class="col-md-3"><label class="control-label">Fecha inicial</label></div>
                        <div class="col-md-3">' . $permiso["FECHA_INI"] . '</div>
                        <div class="col-md-3"><label class="control-label">Fecha final</label></div>
                        <div class="col-md-3">' . $permiso["FECHA_FIN"] . '</div>
                    </div>';
                    break;
                default:
                    break;
            }
        } ?>
        <? if(!empty($permiso["DESCRIPCION"])) { ?>
        <div class="row">
            <div class="col-md-3">
                <label class="control-label">Info. adicional</label>
            </div>
            <div class="col-md-9">
                <?echo $permiso["DESCRIPCION"]?>
            </div>
        </div>
        <? } ?>
        <? if(count($jefe) > 0) { ?>
            <div class="row">
                <div class="col-md-3">
                    <label class="control-label">Jefe encargado de la solicitud</label>
                </div>
                <div class="col-md-9">
                    <?echo $jefe['nombre']?>
                </div>
            </div>
        <? } ?>
    </form>
</div>