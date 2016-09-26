<script type="text/javascript" src="<?php echo base_url("js/gh_asistencia/gh_consulta_asistencia.js"); ?>"></script>

<div class="modal fade" id="myModal" role="dialog"></div>
<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                REPORTE DE ASISTENCIA
            </h4>
        </div>
    </div>
    <div id="divMsgSuccess" class="alert alert-success" <?php echo (strlen($msgSuccess) == 0) ? 'style="display: none;"':'';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgSuccess"><?=$msgSuccess?></strong>
    </div>
    <div id="divMsgAlert" class="alert alert-danger" <?php echo (strlen($msgError) == 0) ? 'style="display: none;"':'';?>>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong id="msgError"><?=$msgError?></strong>
    </div>
    <div class="well">
        <form  name="frmAsistencia" id="frmAsistencia" enctype="multipart/form-data" role="form" method="post">
            <div class="row">
                <div class="col-md-6" id="divFechaIni">
                    <label class="control-label">Desde: *</label>
                    <input type="text" class="form-control" name="fecha_ini" id="fecha_ini" value="<?= $fecha_ini ?>" />
                </div>
                <div class="col-md-6" id="divFechaFin">
                    <label class="control-label">Hasta: *</label>
                    <input type="text" class="form-control" name="fecha_fin" id="fecha_fin" value="<?= $fecha_fin ?>" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="cmbDespacho">Despacho</label>
                    <select id="cmbDespacho" name="cmbDespacho" class="form-control" autocomplete="off"> 
                        <option value="-">Seleccione</option>
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
                        <option value="-">Seleccione</option>
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
                <div class="form-group col-md-4">
                    <label for="txtDocu">Cedula</label>
                    <input type="text" id="txtDocu" name="txtDocu" value="" maxlength="11" class="form-control" placeholder="N&uacute;mero de documento" autofocus value="<?=$cedula?>" />
                </div>
                <div class="form-group col-md-4">
                    <label for="txtNombres">Nombre(s)</label>
                    <input type="text" id="txtNombres" name="txtNombres" value="" maxlength="100" class="form-control" placeholder="Nombre(s)" />
                </div>
                <div class="form-group col-md-4">
                    <label for="txtApellidos">Apellido(s)</label>
                    <input type="text" id="txtApellidos" name="txtApellidos" value="" maxlength="100" class="form-control" placeholder="Apellidos(s)" />
                </div>
            </div>
            <div class="row" align="center">
                <div style="width: 50%;" align="center">
                    <button type="button" class="btn btn-primary" id="btnBuscar" name="btnBuscar" 
                            data-loading-text="<span class='glyphicon glyphicon-refresh glyphicon-refresh-animate'></span> Buscando...">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button>
                    <button type="button" class="btn btn-primary" id="btnExcel" name="btnExcel">
                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Exportar a Excel</button>
                </div>
            </div>
            <div id="deslizarTablaInfo" class="btn">
                <label>Informaci&oacute;n</label>
                <img src="<?= base_url_images('flechaabajo.png') ?>" alt="Mostrar" title="Mostrar" height="16" width="16" />
            </div>
            <div id="tablaInfo">
                <div class="row">
                    <div class="form-group col-md-6">
                        <span for="infoRE" style="font-weight: bold;">RE: </span>
                        <label style="font-weight: normal;">Retardos de entrada</label>
                    </div>
                    <div class="form-group col-md-6">
                        <span for="infoRS" style="font-weight: bold;">RS: </span>
                        <label style="font-weight: normal;">Retardos de salida</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <span for="infoTR" style="font-weight: bold;">TR: </span>
                        <label style="font-weight: normal;">Total de retardos</label>
                    </div>
                    <div class="form-group col-md-6">
                        <span for="infoPerfetti" class="ui-jqgrid-light-blue">Viernes especial:</span>
                        <label style="font-weight: normal;">Fechas que se puede llegar a las 7:30 a.m. y salir a las 3:30 p.m.</label>
                    </div>
                </div>
            </div>
        </form>
        <br />
        <div class="centergrid">
            <table id="listAsistencias"></table>
            <div id="pagerAsistencias"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url("js/general/jquery-ui-timepicker-addon.js"); ?>"></script>
<link href="<?php echo base_url("/css/jquery-ui-timepicker-addon.css"); ?>" rel="stylesheet"/>