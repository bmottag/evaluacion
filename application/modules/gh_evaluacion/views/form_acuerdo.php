<script type="text/javascript" src="<?php echo base_url("js/gh_evaluacion/asignarMacro.js"); ?>"></script>
<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="list-group-item-heading">
                                    Asignac&oacute;n Macroprocesos Gerentes Públicos --- <?php echo $oficina[0]['DESCRIPCION']; ?>
				</h4>
			</div>
		</div>	
	<div class="well">
		<form  name="formulario" id="formulario" role="form" method="post" >
<!-- Id oficini y Id del Acuerdo si existe -->			
<input type="hidden" id="hddIdentificador" name="hddIdentificador" value="<?php echo $informacion[0]['ID_ASIGNAR_MACRO']; ?>"/>
<input type="hidden" id="hddIdOficina" name="hddIdOficina" value="<?php echo $oficina[0]['ID_OFICINA']; ?>"/>
<input type="hidden" id="hddIdAcuerdo" name="hddIdAcuerdo" value="<?php echo $acuerdo['ID_ACUERDO']; ?>"/>
  			<div class="row">
	  			<div class="form-group col-md-3">
                                    <label for="macroproceso">Macroproceso : *</label>
                                    <select name="macroproceso" id="macroproceso" class="form-control">
                                            <option value='' >Seleccione...</option>
                                            <?php for ($i = 0; $i < count($macropoceso); $i++) { 
                                                echo "<option value='" . $macropoceso[$i]->ID_MACROPROCESO . "'>" . $macropoceso[$i]->MACROPROCESO . "</option>";
                                            } ?>
                                    </select>
				</div>
                                <div class="form-group col-md-3">
                                    <label for="definicion">Peso</label>
                                    <input type="text" name="peso" id="peso" class="form-control" placeholder="Peso"  />
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
					<input type="button" id="btnForm" name="btnForm" value="Guardar Datos" class="btn btn-primary"/>
				</div>
			</div>	
		</form>
	</div>
    <div id="resultado"></div><!-- Carga lista -->
</div>