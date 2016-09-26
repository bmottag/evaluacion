<script type="text/javascript" src="<?php echo base_url("js/gh_solicitudpermiso/gh_solicitudpermiso.js"); ?>"></script>	
<script type="text/javascript" src="<?php echo base_url("js/gh_solicitudpermiso/ajax.js"); ?>"></script>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                SOLICITUD DE PERMISO
            </h4>
        </div>
    </div>

    <div class="well">
        <form  name="frmPermisos" id="frmPermisos" enctype="multipart/form-data" role="form" method="post" action="<?php echo site_url("/gh_solicitudpermiso/permisos"); ?>">
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Tipo Permiso : *</label>
                    <select name="tipoPermiso" id="tipoPermiso" class="form-control" onChange="validarTipo()" required>
                        <option value='' >Seleccione...</option>
                        <?php
                        foreach ($tipo as $data):
                            echo "<option value='" . $data['ID_TIPO'] . "'>" . $data['TIPO'] . "</option>";
                        endforeach
                        ?>
                    </select>
                    <label class="control-label">Motivo del permiso : </label>
                    <select name="motivo" id="motivo" class="form-control" onChange="buscarMotivo()" required>
                        <option value='' >Seleccione...</option>
                        <?php
                        // onchange: si cambia el motivo - ejecuta progrma ajax.js
                        foreach ($motivo as $data):
                            echo "<option value='" . $data['ID_MOTIVO'] . "'>" . $data['MOTIVO'] . "</option>";
                        endforeach
                        ?>
                    </select>

                    <div id="labelSubmotivo" style="display: none;">
                        <label class="control-label">Especificar motivo: </label>
                        <select name="idsubmotivo" id="idsubmotivo" class="form-control"></select>
                    </div>





                    <div id="labelOtro" style="display: none;">
                        <label class="control-label"> &iquest;cu&aacute;l? 
                            <input type="text" name="otro" id="otro" class="form-control" required></label> 
                    </div>				
                </div>
                <!-- Tipo de permiso: FRACCION -->
                <div class="col-md-6 alert alert-info" id="fraccion" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 text-right">
                            <label class="control-label">Fecha en que desea tomar el permiso: *</label>
                        </div>
                        <div class="col-md-6">
                            <input type='text' class="form-control" name='fechaPermiso' id='fechaPermiso' />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right"><br>
                            <label class="control-label">A partir de las : *</label>
                        </div>
                        <div class="col-md-3">
                            Hora
                            <select name="hora1" id="hora1" class="form-control" onChange="copiar_valor('hora1', 'minutos1', 'hora_ini');">
                                <option value='' ></option>
                                <?php
                                for ($i = 8; $i <= 16; $i++) {
                                    switch ($i) {
                                        case 8:
                                            $hora = '08';
                                            break;
                                        case 9:
                                            $hora = '09';
                                            break;
                                        default:
                                            $hora = $i;
                                    }
                                    ?>
                                    <option value='<?php echo $hora; ?>' <?php if (isset($convocatoria) && $hora == $convocatoria['hora_inicial']) { ?>selected="selected"<?php } ?>><?php echo $hora; ?></option>
                                <?php } ?>									
                            </select>
                        </div>
                        <div class="col-md-3">
                            Minutos
                            <select name="minutos1" id="minutos1" class="form-control" onChange="copiar_valor('hora1', 'minutos1', 'hora_ini');">
                                <option value='00' >00</option>
                                <option value='30' >30</option>
                            </select>
                        </div>
                        <input id="hora_ini" name="hora_ini" type="hidden" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right"><br>
                            <label class="control-label">Hasta las: *</label>
                        </div>
                        <div class="col-md-3">
                            Hora
                            <select name="hora2" id="hora2" class="form-control" onChange="copiar_valor('hora2', 'minutos2', 'hora_fin');">
                                <option value='' ></option>
                                <?php
                                for ($i = 8; $i <= 17; $i++) {
                                    switch ($i) {
                                        case 8:
                                            $hora = '08';
                                            break;
                                        case 9:
                                            $hora = '09';
                                            break;
                                        default:
                                            $hora = $i;
                                    }
                                    ?>
                                    <option value='<?php echo $hora; ?>' <?php if (isset($convocatoria) && $hora == $convocatoria['hora_inicial']) { ?>selected="selected"<?php } ?>><?php echo $hora; ?></option>
                                <?php } ?>									
                            </select>
                        </div>
                        <div class="col-md-3">
                            Minutos
                            <select name="minutos2" id="minutos2" class="form-control" onChange="copiar_valor('hora2', 'minutos2', 'hora_fin');">
                                <option value='00' >00</option>
                                <option value='30' >30</option>
                            </select>
                        </div>
                        <input id="hora_fin" name="hora_fin" type="hidden" class="form-control">
                    </div>				
                </div>
                <!-- Tipo de permiso: UN DIA & TRES DIAS -->
                <div class="col-md-6 alert alert-info" id="dias" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Fecha en que desea tomar el permiso</label><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Desde: *</label>
                            <input type='text' class="form-control" name='fecha_ini' id='fecha_ini' />
                        </div>
                        <div class="col-md-6" id="dias_final" style="display: none;">
                            <label class="control-label">Hasta: *</label>
                            <input type='text' class="form-control" name='fecha_fin' id='fecha_fin' />
                        </div>
                    </div>
                </div>
                <!-- Tipo de permiso: ESTUDIO Y DOCENCIA -->
                <div class="col-md-6 alert alert-info" id="certUni" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Anexar certificado de estudio universitario : </label>
                            <input type="file" name="archivo1" id="archivo1" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Anexar horario de clases : </label>
                            <input type="file" name="archivo2" id="archivo2" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Estipular el tiempo y la forma de compensar en la jornada laboral : </label>
                            <input type="text" name="tiempoCompensar" id="tiempoCompensar" class="form-control" placeholder="tiempo y forma de compensar" required disabled>
                        </div>
                    </div>
                </div>
            </div>		
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Jefe inmediato : </label>
                    <select name="jefe" id="jefe" class="form-control" required>
                        <option value='' >Seleccione...</option>
                        <?php
                        foreach ($funcionarios as $data):
                            echo "<option value='" . $data['ID_USUARIO'] . "'>" . strtoupper($data['NOM_USUARIO'] . " " . $data['APE_USUARIO']) . "</option>";
                        endforeach
                        ?>
                    </select>							
                </div>
                <div class="col-md-6">
                    <label class="control-label">Autorizaciones para 3 d&iacute;as : </label>			
                    <select name="director" id="director" class="form-control" required disabled>
                        <option value='' >Seleccione...</option>
                        <?php
                        foreach ($director as $data):
                            echo "<option value='" . $data['ID_USUARIO'] . "'>" . strtoupper($data['NOM_USUARIO'] . " " . $data['APE_USUARIO']) . "</option>";
                        endforeach
                        ?>
                    </select>							
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">		
                    <label class="control-label">Informaci&oacute;n adicional si es necesaria</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="1"  ></textarea>
                </div>
            </div>
            <br>
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
                    <div id="div_guardado" style="display:none">			
                        <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>
                    </div>	
                    <div id="div_error" style="display:none">			
                        <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                    </div>	
                    <input type="button" id="btnSolicitud" name="btnSolicitud" value="Enviar solicitud" class="btn btn-primary" onClick="enviarSolicitud();"/>
                </div>
            </div>	
        </form>
    </div>	
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" id="bloqueAlerta" style="display: none;">
                <div class="alert alert-error">
                    <h5>Verificar datos :</h5>
                    <span id="alertTipo" style="display: none;">Seleccionar tipo de permiso</span>
                    <span id="alertFecha" style="display: none;">Seleccionar fecha de permiso</span>
                    <span id="alertFechaMenor" style="display: none;">La fecha del permiso no puede ser menor a la fecha actual</span>
                    <span id="alertFechaMenor2" style="display: none;">La fecha final del permiso no puede ser menor o igual a la fecha inicial</span>
                    <span id="alertInicio" style="display: none;">Seleccionar hora inicio</span>
                    <span id="alertFinal" style="display: none;">Seleccionar hora final</span>
                    <span id="alertFirst" style="display: none;">Seleccionar fecha del permiso</span>
                    <span id="alertSecond" style="display: none;">Seleccionar fechas</span>
                    <span id="alertEstudio" style="display: none;">Indicar tiempo y forma de compensar</span>
                    <span id="alertDocs" style="display: none;">Anexar documentos</span>
                    <span id="alertMotivo" style="display: none;">Seleccionar motivo del permiso</span>
                    <span id="alertOtro" style="display: none;">Indicar cu&aacute;l</span>
                    <span id="alertSubMotivo" style="display: none;">Especificar motivo del permiso</span>
                    <span id="alertJefe" style="display: none;">Seleccionar jefe inmediato</span>
                    <span id="alertDirector" style="display: none;">Seleccionar director</span>
                </div>
            </div>
        </div>
    </div>
</div>