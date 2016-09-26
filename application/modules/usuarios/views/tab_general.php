<script type="text/javascript" src="<?php echo base_url("js/usuarios/usuarios.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/gh_directorio/gh_directorio.js"); ?>"></script>	
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                Informaci&oacute;n B&aacute;sica
            </h4>
        </div>
    </div>	
    <div class="well">
        <form  name="formGeneral" id="formGeneral" role="form" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="form-group col-md-2">
                    <div class="media">
                        <?php
                        if ($user["IMAGEN"] == '') {
                            $user["IMAGEN"] = "img_contacto.png";
                        }
                        ?>
                        <img src="<?php echo base_url("files/funcionarios/thumbs/" . $user["IMAGEN"]); ?>" class="img-thumbnail" >
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <br><br>
                    <strong class='text-error'>Nro. Identificaci&oacute;n: </strong><?php echo $user["NUM_IDENT"]; ?><br>
                    <strong class='text-error'>Nombre: </strong><?php echo $user["NOM_USUARIO"] . ' ' . $user["APE_USUARIO"]; ?><br>
                    <strong class='text-error'>Correo Institucional: </strong><?php echo $user["MAIL_USUARIO"]; ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="cmbDespacho">Despacho: *</label>
                    <select id="cmbDespacho" name="cmbDespacho" class="form-control" autocomplete="off"> 
                        <option value="">Seleccione...</option>
                        <?php
                        $idDespacho = substr($user["DEP_USUARIO"], 0, 1);
                        for ($i = 0; $i < count($despacho); $i++) { ?>
                            <option value="<?php echo $despacho[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $despacho[$i]["id_dependencia"] == $idDespacho) { ?>selected="selected"<?php } ?>><?php echo $despacho[$i]["nom_dependencia"]; ?></option>	
                        <?php } ?>
                    </select>
                </div>	
                <div class="form-group col-md-4">
                    <label for="cmbdependencia">Dependencia: </label>
                    <select name="dependencia" id="dependencia" class="form-control" autocomplete="off">
                        <option value="-">Seleccione...</option>
                        <?php
                        $idDendencia = substr($user["DEP_USUARIO"], 0, 2);
                        for ($i = 0; $i < count($dependencias); $i++) { ?>
                            <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $dependencias[$i]["id_dependencia"] == $idDendencia) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>	
                        <?php } ?>													
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="grupo">Grupo: </label>
                    <select name="grupo" id="grupo" class="form-control" autocomplete="off" >
                        <option value="">Seleccione...</option>
                        <?php for ($i = 0; $i < count($dependencias); $i++) { ?>
                            <option value="<?php echo $dependencias[$i]["id_dependencia"]; ?>" <?php if (isset($user) && $dependencias[$i]["id_dependencia"] == $user["DEP_USUARIO"]) { ?>selected="selected"<?php } ?>><?php echo $dependencias[$i]["nom_dependencia"]; ?></option>	
                        <?php } ?>												
                    </select>
                </div>						
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtTelefono">Tel&eacute;fono: *</label>
                    <input type="text" id="txtTelefono" name="txtTelefono" value="<?php echo (isset($user["TEL_USUARIO"])) ? $user["TEL_USUARIO"] : ""; ?>" maxlength="10" class="form-control" placeholder="Tel&eacute;fono"  >
                </div>  
                <div class="form-group col-md-2">
                    <label for="txtExtension">Extensi&oacute;n: *</label>
                    <input type="text" id="txtExtension" name="txtExtension" value="<?php echo (isset($user["EXT_USUARIO"])) ? $user["EXT_USUARIO"] : ""; ?>" maxlength="6" class="form-control" placeholder="Extensi&oacute;n" >
                </div>  				
            </div>	
			<div class="row">
				<div class="col-md-12">
                                        
                                        <?php if($user["POLITICA"] == 1){ ?>
                                                <div class="alert alert-info">
                                                    <input type="hidden" name="politica" id="politica" value="off" /> 
                                                    <h5 style="text-align: center;">Ten en cuenta que también podrás registrar tu “Información Personal” y subir tu “Foto de Perfil”, 
                                                    seleccionando las respectivas pestañas ubicadas en la parte superior de este formulario.
                                                    </h5>
                                                    <h5 style="text-align: center;">Una vez diligenciada la información, podras continuar con el formulario de "Información Académica".
                                                    </h5>
                                                </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <h4 class="text-center">Aviso de privacidad para recolección de datos personales</h4>
                                                <p style="text-align: justify;">En mi calidad de titular de información personal, actuando libre y voluntariamente, al diligenciar los datos aquí solicitados, autorizo al Departamento 
                                                    Administrativo Nacional de Estadística - DANE, para que de forma directa o a través de terceros realice el tratamiento de mi información personal, el 
                                                    cual consiste en recolectar, almacenar, usar, transferir y administrar mis datos personales, para:
                                                </p><br>
                                                <ol>
                                                    <li>Formular, ejecutar y evaluar planes de acción, programas de bienestar, capacitación, salud ocupacional y planes de atención a emergencias.</li>
                                                    <li>Mantener actualizada la historia laboral y registros de nómina de los servidores públicos del DANE.</li>
                                                    <li>Atender y resolver peticiones, quejas, reclamos y sugerencias.</li>
                                                    <li>Atender requerimientos de información de entes de control tanto internos como externos.</li>
                                                    <li>Medir y realizar seguimiento a los niveles de satisfacción de los clientes internos de la Entidad, a través de encuestas.</li>
                                                </ol><br>
                                                <p style="text-align: justify;">
                                                    Entiendo que las políticas para el tratamiento de mi información personal, así como el procedimiento para elevar cualquier solicitud, queja o reclamo, 
                                                    podrán ser consultados en el sitio www.dane.gov.co. De manera expresa manifiesto que conozco, entiendo y he sido informado de mis derechos como titular de 
                                                    datos personales frente a i) conocer, actualizar y rectificar los datos personales, ii) solicitar prueba de la autorización otorgada para su tratamiento, 
                                                    iii) ser informado por el DANE, previa solicitud, respecto del uso que le ha dado a los datos personales, iv) presentar quejas ante la Superintendencia de 
                                                    Industria y Comercio por infracciones a la ley, v) revocar la autorización y/o solicitar la supresión del(los) dato(s) en los casos en que sea procedente, y 
                                                    vi) acceder en forma gratuita a los mismos. Lo anterior, de conformidad con el Artículo 15 de la Constitución Nacional, la Ley Estatutaria 1581 de 2012 y el Decreto 1377 de 2013.
                                                </p>
                                                <br>
                                                <input type="checkbox" name="politica" id="politica" /> 
                                                Entiendo y acepto lo establecido en el aviso de privacidad para recolección de datos personales, en los términos de la Ley 1581 de 2012.
                                            </div>
                                        <?php
                                            }
                                        ?>
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
                    <input type="button" id="btnGeneral" name="btnGeneral" class="btn btn-primary" value="Guardar" />
                </div>
            </div>	
        </form>
    </div>
</div>