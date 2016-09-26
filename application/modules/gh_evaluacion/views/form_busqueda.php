<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="list-group-item-heading">
					VER ACUERDOS
				</h4>
			</div>
		</div>	
	<div class="well">
            <form  name="formulario" id="formulario" role="form" method="post" >
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="cmbDespacho">Vigencia : *</label>
                        <select name="vigencia" id="vigencia" class="form-control" required>
                            <option value='' >Seleccione...</option>
                            <?php
								$annoActual = date('Y');
								for ($i = $annoActual; $i > 2015; $i--) {
									?>
									<option value='<?php echo $i; ?>' ><?php echo $i; ?></option>
							<?php } ?>									
                        </select>
                    </div>	
                    <div class="col-md-2">
                            <label for="evaluador">Evaluador :</label>
                            <select name="evaluador" id="evaluador" class="form-control" >
                                    <option value='' >Seleccione...</option>
                                    <option value=1 >Director</option>
                                    <option value=2 >Subdirector</option>
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
						<input type="submit" name="Button" value="Buscar" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
	</div>
</div>