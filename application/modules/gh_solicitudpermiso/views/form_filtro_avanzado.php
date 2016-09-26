<script type="text/javascript" src="<?php echo base_url("js/gh_solicitudpermiso/validacion_filtro.js"); ?>"></script>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                Reporte de solicitud de permisos en EXCEL
            </h4>
        </div>
    </div>
    <div class="well">
        <form  name="frmFiltro" id="frmFiltro" role="form" method="post" action="<?php echo site_url("/gh_solicitudpermiso/admin_permisos/generar_xls"); ?>">
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Fecha de solicitud desde: *</label>
                    <input type="text" class="form-control" name="fecha_ini" id="fecha_ini" value="<?=$fecha_ini?>" />
                </div>
                <div class="col-md-6">
                    <label class="control-label">Fecha de solicitud hasta: *</label>
                    <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" value="<?=$fecha_fin?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Tipo Permiso:</label>
                    <select name="tipoPermiso" id="tipoPermiso" class="form-control" >
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($tipo as $data):
                            echo "<option value='" . $data['ID_TIPO'] . "'>" . $data['TIPO'] . "</option>";
                        endforeach
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Motivo del permiso:</label>
                    <select name="motivo" id="motivo" class="form-control">
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($motivo as $data):
                            echo "<option value='" . $data['ID_MOTIVO'] . "'>" . $data['MOTIVO'] . "</option>";
                        endforeach
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="cmbDespacho">Despacho</label>
                    <select id="cmbDespacho" name="cmbDespacho" class="form-control" autocomplete="off"> 
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($arrDespacho as $data):
                            $tag = ($data['id_dependencia'] == $codi_desp) ? 'selected' : '';
                            echo "<option value='" . $data['id_dependencia'] . "' " . $tag . ">" . $data['nom_dependencia'] . "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>	
                <div class="form-group col-md-4">
                    <label for="cmbdependencia">Dependencia</label>
                    <select name="dependencia" id="dependencia" class="form-control" autocomplete="off">
                        <option value="">Seleccione</option>
                        <?php
                        foreach ($arrDepe as $data):
                            $tag = ($data['id_dependencia'] == $codi_depe) ? 'selected' : '';
                            echo "<option value='" . $data['id_dependencia'] . "' " . $tag . ">" . $data['nom_dependencia'] . "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="grupo">Grupo</label>
                    <select name="grupo" id="grupo" class="form-control" autocomplete="off" >
                        <option value="">Seleccione</option>
                    </select>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-12 alert alert-info">
                    Generar reporte con el n&uacute;mero de permisos por funcionario
                    <br />
                    <input type="checkbox" name="agrupado" value="1">&nbsp;
                    <label class="control-label">Agrupar permisos aprobados por funcionario </label>
                </div>
            </div>
            <div class="row">
                <div align="center">
                    <div id="div_cargando" style="display: none;">
                        <div class="progress progress-striped active">
                            <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                <span class="sr-only">45% completado</span>
                            </div>
                        </div>
                    </div>	
                    <div id="div_guardado" style="display: none;">
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>
                    </div>	
                    <div id="div_error" style="display: none;">
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                    </div>
                    <input type="button" id="btnSolicitud" name="btnSolicitud" value="Descargar Reporte" class="btn btn-primary" onClick="enviarSolicitud();" />
                </div>
            </div>
        </form>
    </div>
    <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"':'';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgSuccess"><?=$msgSuccess?></strong>
    </div>
    <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"':'';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgError"><?=$msgError?></strong>
    </div>
</div>