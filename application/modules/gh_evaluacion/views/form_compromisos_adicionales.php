<script type="text/javascript" src="<?php echo base_url("js/gh_evaluacion/compromisosAdicionales.js"); ?>"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="list-group-item-heading">
                        CALIFICAR LOS COMPROMISOS ADICIONALES 
                    </h4>
                </div>
            </div>
        </div>			
    </div>
		<div class="alert alert-info" role="alert">
			<strong>Formulario </strong> para calificar los compromisos adicinales.
		</div>	

    <!--INICIO DATOS DEPENDENCIA -->
    <div class="well">
        <div class="row">
            <div class="col-md-5">	
                <strong class='text-error'>DEPENDENCIA / TERRITORIAL:</strong><br />
                <?php echo $acuerdo[0]->DESCRIPCION; ?>

                <?php
                if ($acuerdo[0]->TIPO_GERENTE_PUBLICO == 1) {//gerente publico = direcciones territoriales
                    //informacion de los parcentajes y pesos para el area
                    $info_area = $this->consultas_generales->get_consulta_basica('EVAL_PARAM_AREA', 'AREA');
                    foreach ($info_area as $area):
                        echo '<br><strong>' . $area['AREA'] . ':</strong> ' . $area['PORCENTAJE_AREA'] . '%';
                    endforeach;
                }
                ?>
                <br><br><a class="btn btn-success" href=" <?php echo base_url() . 'gh_evaluacion/acuerdo/' . $acuerdo[0]->ID_ACUERDO; ?> "><span class="glyphicon glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Regresar </a>       
            </div>
            <div class="col-md-4">
                <strong class='text-error'>ID ACUERDO: </strong><?php echo $acuerdo[0]->ID_ACUERDO; ?><br/>
                <strong class='text-error'>Vigencia: </strong><?php echo $acuerdo[0]->VIGENCIA; ?><br/>
                <strong class='text-error'><?php echo $usuarioEvaluador['cargo'];?>: </strong><?php echo $usuarioEvaluador['nom_usuario'] . ' ' . $usuarioEvaluador['ape_usuario'];?><br/>
                <strong class='text-error'>Gerente P&uacute;blico: </strong><?php echo $usuarioJefe['nom_usuario'] . ' ' . $usuarioJefe['ape_usuario'];?>
            </div>
            <div class="col-md-3">
                <strong class='text-error'>DESCARGAR DOCUMENTOS:</strong><br />
                <?php if ($completa) { ?>
                    <a href='<?php echo base_url('gh_evaluacion/generaAcuerdoPDF/' . $acuerdo[0]->ID_ACUERDO); ?>'><img src='<?php echo base_url_images('pdf.png'); ?>' >&nbsp;Descargar Compromisos</a><br>
                    <a href='<?php echo base_url('gh_evaluacion/generaPDF/' . $acuerdo[0]->ID_ACUERDO); ?>'><img src='<?php echo base_url_images('pdf.png'); ?>' >&nbsp;Descargar Acuerdo</a>
                    <?php if ($detalle) { ?>
                        <br><a href='<?php echo base_url('gh_evaluacion/compromisoPDF/' . $acuerdo[0]->ID_ACUERDO); ?>'><img src='<?php echo base_url_images('pdf.png'); ?>' >&nbsp;Descargar Compromisos Adicionales</a>
                    <?php } ?>

                <?php
                } else {
                    echo "Debe finalizar la asignaci&oacute;n de compromisos.";
                }
                ?>
            </div>
        </div>
    </div>
    <!--FIN DATOS DEPENDENCIA -->

    <form  name="formulario" id="formulario" role="form" method="post">
        <div class="row">
            <div class="col-md-12">
                <table class='table table-bordered table-striped table-hover table-condensed'>
                    <tr class='info'>
                        <td class='text-center' colspan=6><strong>COMPROMISOS DE MEJORA GERENCIAL</td>
                    </tr>
                    <tr class="active">
                        <th class='text-center' colspan=2 rowspan=2>Competencias B&aacute;sicas Gerenciales</th>
                        <th class='text-center'rowspan=2>Indicadores<br>(S&iacute;ntesis de Conductas Asociadas)</th>
                        <th class='text-center'colspan=3>Necesidades Mejora Gerencial</th>
                    </tr>
                    <tr class="active">
                        <th class='text-center'>No se detectan</th>
                        <th class='text-center'>Se detectan</th>
                        <th class='text-center'>Son imprescindibles</th>
                    </tr>
                    <?php
                    foreach ($compromisos as $datos):
                        echo "<tr>";
                        echo "<td class='text-center'><small>" . $datos['COMPROMISO'] . "</small></td>";
                        echo "<td ><small>" . $datos['DESCRIPCION'] . "</small></td>";
                        echo "<td ><small>" . $datos['INDICADORES'] . "</small></td>";

                        for ($i = 1; $i <= 3; $i++) {
                            echo "<td class='text-center'>";
                            $req = 'required';
                            $name = 'compromiso' . $datos['ID_COMPROMISO'];
                            $check = FALSE;
                            if (isset($datos['NECESIDAD_MEJORA']) && $i == $datos['NECESIDAD_MEJORA']) {
                                $check = TRUE;
                            }
                            echo form_radio($name, $i, $check, $req);
                            echo '</td>';
                        }

                        echo "</tr>";
                    endforeach;
                    echo "</table>";
                    ?>
                <table>
                    <tr>
                        <td style="text-align: justify;">
                            <strong>NOTA:</strong> Las anteriores son las competencias m&iacute;nimas que debe tener el Gerente P&uacute;blico. 
                            Por tal raz&oacute;n pueden ser adicionadas otras, si la entidad lo considera necesario. 
                            La finalidad de estos compromisos no es otra que reforzar las competencias de los gerentes p&uacute;blicos 
                            mediante la identificaci&oacute;n puntual de cu&aacute;les pueden ser los &aacute;mbitos competenciales en 
                            los que el gerente p&uacute;blico requiere de una capacitaci&oacute;n o formaci&oacute;n complementaria.
                        </td>
                    </tr>
                </table>
                <br>
                </div>
                    <div class="col-md-12">
                            <label for="message-text" class="control-label">OBSERVACIONES : </label>
                            <textarea class="form-control" name="observacion" id="observacion" rows="2" ><?php echo $acuerdo[0]->OBSERVACIONES; ?></textarea>
                    </div>
                </div>
                <br>
                <table>
                    <tr>
                        <td style="text-align: justify;">
                            <strong>NOTA:</strong> La finalidad de los compromisos de mejora gerencial, como su propio nombre indica, no es otra que reforzar 
                            las competencias de los gerentes p&uacute;blicos mediante la identificaci&oacute;n puntual de cu&aacute;les pueden 
                            ser los &aacute;mbitos competenciales en los que el gerente p&uacute;blico requiere de una capacitaci&oacute;n o 
                            formaci&oacute;n complementaria. Esta es la &uacute;nica consecuencia de esos compromisos gerenciales, y por tanto 
                            requiere que el superior jer&aacute;rquico (por s&iacute; mismo o por compartir la idea con el gerente) identifique 
                            en qu&eacute; &aacute;mbitos de las competencias gerenciales se requiere invertir en capacitaci&oacute;n con el 
                            fin de mejorar el rendimiento institucional y fomentar el desarrollo del Gerente P&uacute;blico. En la Casilla 
                            "Observaciones" se relacionan, por tanto, esas necesidades de capacitaci&oacute;n detectadas.
                        </td>
                    </tr>
                </table>
                <br>
        <div class="row" align="center">
            <div style="width:50%;" align="center">
				<?php
					if($detalle)
					{//si ya se realizo la calificacion entonces no se muesta el boton
					
				?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
						Ya se realizó la calificación de los compromisos adicionales.
					</div>
				<?php
					}else{
						//habilitar boton solo si el director o el subdirecor
						$deshabilitar = 'disabled';
						if($codDependencia<3){
							$deshabilitar = "";
						}
				?>
					<input type="button" id="btnGuardar" name="btnGuardar" value="Guardar" class="btn btn-primary" <?php echo $deshabilitar; ?>/>
				<?php
					}
				?>
            </div>
        </div>
    </form>
</div>