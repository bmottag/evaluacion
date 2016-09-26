<script type="text/javascript" src="<?php echo base_url("js/gh_evaluacion/pilar.js"); ?>"></script>
<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="list-group-item-heading">
					ADICIONAR/EDITAR PILAR ESTRAT&Eacute;GICO
				</h4>
			</div>
		</div>
		<div class="alert alert-info" role="alert">
			<strong>Formulario </strong> para adicionar y editar pilares estrat&eacute;gicos.
		</div>	
	<div class="well">
            <form  name="formulario" id="formulario" role="form" method="post" >
                <input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $informacion?$informacion[0]["ID_PILAR"]:""; ?>"/>
                <div class="row">
                    <div class="form-group col-md-5">
                        <label for="pilar">Pilar Estrat&eacute;gico</label>
                        <input type="text" id="pilar" name="pilar" value="<?php echo $informacion?$informacion[0]["PILAR"]:""; ?>" class="form-control" placeholder="Pilar Estrat&eacute;gico" required >
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
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="definicion">Definici&oacute;n</label>
                        <textarea class="form-control" name="definicion" id="definicion" rows="2" > <?php echo $informacion?$informacion[0]["DEFINICION_PILAR"]:""; ?></textarea>
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