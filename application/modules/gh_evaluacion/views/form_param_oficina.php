<script type="text/javascript" src="<?php echo base_url("js/gh_directorio/gh_directorio.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/gh_evaluacion/oficina.js"); ?>"></script>
<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="list-group-item-heading">
					ASIGNAR EVALUADOR 
				</h4>
			</div>
		</div>
		<div class="alert alert-info" role="alert">
			<strong>Formulario </strong> para asignar el evaluador de la dependencia.
		</div>
	<div class="well">
            <form  name="formulario" id="formulario" role="form" method="post" >
                <input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $informacion?$informacion[0]["ID_OFICINA"]:""; ?>"/>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="cmbDespacho">Despacho</label>
                        <select id="cmbDespacho" name="cmbDespacho" class="form-control" > 
                            <option value="-">Seleccione...</option>
                            <?php
                            $idDespacho = substr($informacion[0]["FK_ID_DEPENDENCIA"], 0, 1);
                            for ($i = 0; $i < count($despacho); $i++) {
                                ?>
                                <option value="<?php echo $despacho[$i]["id_dependencia"]; ?>" <?php if ($informacion && $despacho[$i]["id_dependencia"] == $idDespacho) { ?>selected="selected"<?php } ?>><?php echo $despacho[$i]["nom_dependencia"]; ?></option>	
                            <?php } ?>
                        </select>
                    </div>	
                    <div class="form-group col-md-5">
                        <label for="dependencia">Dependencia: *</label>
                        <select name="dependencia" id="dependencia" class="form-control" >
                            <option value="">Seleccione...</option>
                            <?php
                            $idDendencia = $informacion[0]["FK_ID_DEPENDENCIA"];
                            for ($i = 0; $i < count($dependencias); $i++) {
                                ?>
                                <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if ($informacion && $dependencias[$i]["id_dependencia"] == $idDendencia) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>	
                            <?php } ?>													
                        </select>
                    </div>
                    <div class="col-md-2">
                            <label for="evaluador">Evaluador: *</label>
                            <select name="evaluador" id="evaluador" class="form-control" >
                                    <option value='' >Seleccione...</option>
                                    <option value=1 <?php if(1==$informacion[0]["EVALUADOR"]){?>selected="selected"<?php }?>>Director</option>
                                    <option value=2 <?php if(2==$informacion[0]["EVALUADOR"]){?>selected="selected"<?php }?>>Subdirector</option>
                            </select>
                    </div>
					<div class='col-md-2'>
						<label class="control-label">Estado : *</label>
						<select name="estado" id="estado" class="form-control" >
							<option value='' >Seleccione...</option>
							<option value='1' <? if($informacion[0]["ESTADO"] == '1') { echo "selected "; }  ?>>Activo</option>
							<option value='2' <? if($informacion[0]["ESTADO"] == '2') { echo "selected "; }  ?>>Bloqueado</option>
						</select>
					</div>					
				</div>
                <br>	
                <div class="row" align="center">
                    <div style="width:50%;" align="center">
                        <div id="div_cargando" style="display:none">		
                            <div class="progress progress-striped active">
                                <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                    <span class="sr-only">45% completado</span>
                                </div>
                            </div>
                        </div>	
                        <div id="div_guardado_academica" style="display:none">			
                            <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>
                        </div>	
                        <div id="div_error_academica" style="display:none">			
                            <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                        </div>	
                        <input type="button" id="btnForm" name="btnForm" value="Guardar Datos" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
	</div>
    <div id="resultado"></div><!-- Carga lista -->
</div>