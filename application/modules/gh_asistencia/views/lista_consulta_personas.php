<script type="text/javascript" src="<?php echo base_url("js/gh_asistencia/gh_consulta_personas.js"); ?>"></script>

<div class="container-fluid">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                ADICIONAR/EDITAR CÓDIGO DE BARRAS
            </h4>
        </div>
    </div>
    <div class="well">
        <form  name="frmPersonasAsis" id="frmPersonasAsis" enctype="multipart/form-data" role="form" method="post">
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
                        <option value="">Seleccione...</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtDocu">Cedula</label>
                    <input type="text" id="txtDocu" name="txtDocu" value="" maxlength="11" class="form-control" placeholder="N&uacute;mero de documento" value="<?=$cedula?>" autofocus />
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
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar</button>&nbsp;
                        <button type="button" class="btn btn-primary" id="btnDescargarCB" name="btnDescargarCB">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Descargar CB</button>&nbsp;
                        <button type="button" class="btn btn-primary" id="btnDescargarCB8" name="btnDescargarCB8">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Descargar CB EAN8</button>&nbsp;
                </div>
            </div>
        </form>
        <br />
        <div class="centergrid" style="width: 100%;">
            <form name="formCBSele" id="formCBSele" target="_blank" method="POST">
                <input type="hidden" name="codigoBarrasSele" id="codigoBarrasSele" size="150" />
            </form>
            <table id="listPersonasAsis"></table>
            <div id="pagerPersonasAsis"></div>
        </div>
    </div>
</div>