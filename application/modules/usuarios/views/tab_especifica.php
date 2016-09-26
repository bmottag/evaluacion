<script type="text/javascript" src="<?php echo base_url("js/usuarios/tabEspecifica.js"); ?>"></script>	
<div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="list-group-item-heading">
                    Informaci&oacute;n Personal
                </h4>
            </div>
        </div>	
    <div class="well">
        <form  name="formEspecifico" id="formEspecifico" role="form" method="post" >
            <input type="hidden" id="hddIDUsuario" name="hddIDUsuario" value="<?php echo $infoEspecifica?$infoEspecifica["FK_ID_USUARIO"]:""; ?>"/>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="ciudadResidencia">Ciudad o municipio de residencia: *</label>
                    <select name="ciudadResidencia" id="ciudadResidencia" class="form-control" autocomplete="off">
                        <option value="">Seleccione...</option>
                        <?php for ($i = 0; $i < count($municipio); $i++) { ?>
                            <option value="<?php echo $municipio[$i]["COD_MUNICIPIO"]; ?>" <?php if (isset($user) && $municipio[$i]["COD_MUNICIPIO"] == $user["FK_COD_MUNICIPIO"]) { ?>selected="selected"<?php } ?>><?php echo $municipio[$i]["NOM_MUNICIPIO"]; ?></option>	
                        <?php } ?>													
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="txtDireccion">Direcci&oacute;n de Residencia: *</label>
                    <input type="text" id="txtDireccion" name="txtDireccion" value="<?php echo (isset($user["DIRECCION"])) ? $user["DIRECCION"] : ""; ?>" maxlength="80" class="form-control" placeholder="Direcci&oacute;n de Residencia" >
                </div>			
                <div class="form-group col-md-3">
                    <label for="txtBarrio">Barrio : *</label>
                    <input type="text" id="txtBarrio" name="txtBarrio" value="<?php echo (isset($user["BARRIO"])) ? $user["BARRIO"] : ""; ?>" maxlength="30" class="form-control" placeholder="Barrio"  >
                </div> 
            </div>			
			
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="departamento">Lugar de nacimiento - Departamento :</label>
                    <select name="departamento" id="departamento" class="form-control" autocomplete="off">
                        <option value="-">Seleccione...</option>
                        <?php for ($i = 0; $i < count($departamento); $i++) { ?>
                            <option value="<?php echo $departamento[$i]["COD_DEPARTAMENTO"]; ?>" <?php if (isset($infoEspecifica) && $departamento[$i]["COD_DEPARTAMENTO"] == $infoEspecifica["COD_DEPARTAMENTO"]) { ?>selected="selected"<?php } ?>><?php echo $departamento[$i]["NOM_DEPARTAMENTO"]; ?></option>	
                        <?php } ?>													
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="municipio">Lugar de nacimiento - Municipio : *</label>
                    <select name="municipio" id="municipio" class="form-control" autocomplete="off" >
                        <option value="">Seleccione...</option>
                        <?php for ($i = 0; $i < count($municipio); $i++) { ?>
                            <option value="<?php echo $municipio[$i]["COD_MUNICIPIO"]; ?>" <?php if (isset($infoEspecifica) && $municipio[$i]["COD_MUNICIPIO"] == $infoEspecifica["MPIO_NACIMIENTO"]) { ?>selected="selected"<?php } ?>><?php echo $municipio[$i]["NOM_MUNICIPIO"]; ?></option>	
                        <?php } ?>											
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <script type="text/javascript">
                        $(function () {
                            $('#fechaNacimiento').datepicker({
                                dateFormat: 'dd/mm/yy'
                            });
                        })
                    </script>				
                    <label for="fechaNacimiento">Fecha de nacimiento : *</label>					
                    <input type='text' id='fechaNacimiento' name='fechaNacimiento' value="<?php echo $infoEspecifica ? $infoEspecifica["FECHA_NACIMIENTO"] : ""; ?>" size='10' class="form-control" placeholder="Fecha de Nacimiento" required />
                </div> 
            </div>

            <div class="row">
                <div class="form-group col-md-3">
                    <label for="txtCorreoPersonal">Correo Personal: *</label>
                    <input type="text" id="txtCorreoPersonal" name="txtCorreoPersonal" value="<?php echo (isset($user["MAIL_PERSONAL"])) ? $user["MAIL_PERSONAL"] : ""; ?>" class="form-control" placeholder="Correo Personal" >
                </div>
                <div class="form-group col-md-3">
                    <label for="txtCelular">N&uacute;mero de Celular: *</label>
                    <input type="text" id="txtCelular" name="txtCelular" value="<?php echo (isset($user["CELULAR"])) ? $user["CELULAR"] : ""; ?>" maxlength="10" class="form-control" placeholder="N&uacute;mero de Celular" >
                </div>			 				
                <div class="col-md-2">
                    <label for="sexo">Sexo : *</label>
                    <select name="sexo" id="sexo" class="form-control"  >
                        <option value='' >...</option>
                        <option value='F' <?php if ('F' == $user["SEXO"]) { ?>selected="selected"<?php } ?> >Femenino</option>
                        <option value='M' <?php if ('M' == $user["SEXO"]) { ?>selected="selected"<?php } ?> >Masculino</option>					
                    </select>
                </div>
            </div>	
            
			<?php
			$mostrar = 'style="display: none;"';
			if (isset($user["SEXO"]) && 'M' == $user["SEXO"]) {
				$mostrar = '';
			}
			?>
			<div class="col-md-12 alert alert-info" id="libreta" <?php echo $mostrar; ?>>
				<div class="row">
					<div class="col-md-3">
						<label for="libretaMilitar">Número libreta militar : </label>
						<input type="text" id="libretaMilitar" name="libretaMilitar" value="<?php echo $infoEspecifica ? $infoEspecifica["LIBRETA_MILITAR"] : ""; ?>" maxlength="20" class="form-control" placeholder="Libreta Militar" >
					</div>
					<div class="col-md-2">
						<label for="claseLibreta">Clase Libreta : </label>
						<select name="claseLibreta" id="claseLibreta" class="form-control"  >
							<option value='' >Seleccione...</option>
							<option value=1 <?php if (1 == $infoEspecifica["CLASE_LIBRETA"]) { ?>selected="selected"<?php } ?> >Primera clase</option>
							<option value=2 <?php if (2 == $infoEspecifica["CLASE_LIBRETA"]) { ?>selected="selected"<?php } ?> >Segunda clase</option>					
						</select>
					</div>	
					<div class="col-md-3">
						<label for="distritoMilitar">Número distrito militar : </label>
						<input type="text" id="distritoMilitar" name="distritoMilitar" value="<?php echo $infoEspecifica ? $infoEspecifica["DISTRITO_MILITAR"] : ""; ?>" maxlength="20" class="form-control" placeholder="Distrito Militar" >
					</div>	
					<div class="col-md-3">
						<label for="lugarExpedicion">Lugar Expedici&oacute;n : </label>
						<input type="text" id="lugarExpedicion" name="lugarExpedicion" value="<?php echo $infoEspecifica ? $infoEspecifica["LUGAR_EXPEDICION"] : ""; ?>" maxlength="20" class="form-control" placeholder="Lugar Expedici&oacute;n" >
					</div>	                
				</div>         
			</div>
            
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="licencia">N&uacute;mero licencia de conducci&oacute;n : </label>
                    <input type="text" id="licencia" name="licencia" value="<?php echo $infoEspecifica ? $infoEspecifica["LICENCIA_CONDUCCION"] : ""; ?>" maxlength="20" class="form-control" placeholder="Licencia Conducci&oacute;n" >
                </div>
                <div class="col-md-3">
                    <label for="vivienda">La vivienda que habita es : *</label>
                    <select name="vivienda" id="vivienda" class="form-control" >
                        <option value='' >Seleccione...</option>
                        <option value=1 <?php if (1 == $infoEspecifica["VIVIENDA_HABITA"]) { ?>selected="selected"<?php } ?> >Propia</option>
                        <option value=2 <?php if (2 == $infoEspecifica["VIVIENDA_HABITA"]) { ?>selected="selected"<?php } ?> >Arrendada</option>
                        <option value=3 <?php if (3 == $infoEspecifica["VIVIENDA_HABITA"]) { ?>selected="selected"<?php } ?> >Familiar</option>
                    </select>
                </div>	
                <div class="col-md-2">
                    <label for="tipoSangre">Tipo de Sangre : *</label>
                    <select name="tipoSangre" id="tipoSangre" class="form-control" >
                        <option value='' >Seleccione...</option>
                        <?php for ($i = 0; $i < count($tipoSangre); $i++) { ?>
                            <option value="<?php echo $tipoSangre[$i]["ID_TIPO_SANGRE"]; ?>" <?php if (isset($infoEspecifica) && $tipoSangre[$i]["ID_TIPO_SANGRE"] == $infoEspecifica["FK_TIPO_SANGRE"]) { ?>selected="selected"<?php } ?>><?php echo $tipoSangre[$i]["TIPO_SANGRE"]; ?></option>	
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="estadoCivil">Estado Civil : *</label>
                    <select id="estadoCivil" name="estadoCivil" class="form-control" required > 
                        <option value="">Seleccione...</option>
                        <?php for ($i = 0; $i < count($estadoCivil); $i++) { ?>
                            <option value="<?php echo $estadoCivil[$i]["ID_ESTADO_CIVIL"]; ?>" <?php if (isset($infoEspecifica) && $estadoCivil[$i]["ID_ESTADO_CIVIL"] == $infoEspecifica["FK_ESTADO_CIVIL"]) { ?>selected="selected"<?php } ?>><?php echo $estadoCivil[$i]["ESTADO_CIVIL"]; ?></option>	
                        <?php } ?>
                    </select>					
                </div>						
            </div>
  <!--          <div class="row">
                <div class="form-group col-md-3">
                    <label for="pension">C&oacute;digo Fondo Pensiones : </label>
                    <input type="text" id="pension" name="pension" value="<?php echo $infoEspecifica ? $infoEspecifica["FONDO_PENSIONES"] : ""; ?>" maxlength="50" class="form-control" placeholder="C&oacute;digo Fondo Pensiones" >
                </div>
                <div class="form-group col-md-3">
                    <label for="eps">C&oacute;digo EPS : </label>
                    <input type="text" id="eps" name="eps" value="<?php echo $infoEspecifica ? $infoEspecifica["EPS"] : ""; ?>" maxlength="50" class="form-control" placeholder="C&oacute;digo EPS" >	
                </div>			
                <div class="form-group col-md-3">
                    <label for="arp">C&oacute;digo ARP : </label>
                    <input type="text" id="arp" name="arp" value="<?php echo $infoEspecifica ? $infoEspecifica["ARP"] : ""; ?>" maxlength="50" class="form-control" placeholder="C&oacute;digo ARP" >
                </div> 
                <div class="form-group col-md-3">
                    <label for="compensacion">Caja Compensaci&oacute;n : </label>
                    <input type="text" id="compensacion" name="compensacion" value="<?php echo $infoEspecifica ? $infoEspecifica["CAJA_COMPENSACION"] : ""; ?>" maxlength="50" class="form-control" placeholder="Caja Compensaci&oacute;n" >
                </div>                 
            </div>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="adminARP">Administradora de Riesgos Profesionales - ARP : </label>
                    <input type="text" id="adminARP" name="adminARP" value="<?php echo $infoEspecifica ? $infoEspecifica["ADMIN_ARP"] : ""; ?>" maxlength="50" class="form-control" placeholder="Administradora de Riesgos Profesionales - ARP" >
                </div>
                <div class="form-group col-md-6">
                    <label for="adminAFP">Administradora de Fondo de Pensiones - AFP : </label>
                    <input type="text" id="adminAFP" name="adminAFP" value="<?php echo $infoEspecifica ? $infoEspecifica["ADMIN_AFP"] : ""; ?>" maxlength="50" class="form-control" placeholder="Administradora de Fondo de Pensiones - AFP" >	
                </div>			
            </div>
      -->      
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="alergia">Si tiene una alergia, indiquela: </label>
                    <input type="text" id="alergia" name="alergia" value="<?php echo $infoEspecifica ? $infoEspecifica["ALERGIA"] : ""; ?>" maxlength="100" class="form-control" placeholder="Alergia" >	
                </div>			
            </div>

            <div class="row">
                <div class="form-group col-md-8">
                    <label for="enfermedad">Si tiene una enfermedad laboral, indiquela: </label>
                    <input type="text" id="enfermedad" name="enfermedad" value="<?php echo $infoEspecifica ? $infoEspecifica["ENFERMEDAD"] : ""; ?>" maxlength="100" class="form-control" placeholder="Enfermedad Laboral" >	
                </div>			
            </div>
            
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="discapacidad">Si tiene una discapacidad, indiquela: </label>
                    <input type="text" id="discapacidad" name="discapacidad" value="<?php echo $infoEspecifica ? $infoEspecifica["DISCAPACIDAD"] : ""; ?>" maxlength="100" class="form-control" placeholder="Discapacidad" >	                </div>			
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
                    <input type="button" id="btnEspecifica" name="btnEspecifica" value="Guardar Informaci&oacute;n" class="btn btn-primary"/>
                </div>
            </div>	
        </form>
    </div>
</div>