<html>
<head>
<title>certificado</title>

<style type="text/css">

    body{
        height:100%; margin:0;
        font-family:10px Helvetica, Arial, sans-serif;
        background: #ffffff;
    }              

    h3{
       font-size:14pt;
       text-align:center;
       padding:0 0 15px;
    }     

    #conteiner{min-height:100%; }

    #content {
        margin:0 auto;
        position: relative;
    }            
        
</style>
</head>
<body >


<div id="conteiner">
    <div id="content">
	<table border="0" style="border-collapse: collapse; font-family:Helvetica, Arial, sans-serif;" width="90%" >
		<tr>
			<td>
				<table border="0" style="border-collapse: collapse;" width="90%">
					<tr>
						<td width="10%" style="vertical-align: middle; text-align: center;">ACUERDO</td>
                                                <td width="80%" style="vertical-align: middle; font-size: large; font-weight: bold; text-align: center;"><?php echo $acuerdo[0]->DESCRIPCION; ?> </td>                                               
						<td width="10%" style="vertical-align: middle; text-align: center;">
                                                <label style="vertical-align: middle; font-size: large;">Vigencia</label><br><?php echo $acuerdo[0]->VIGENCIA; ?>
						</td>
					</tr>
				</table>
                                <table>
                                    <tr>
                                        <td style="font-size: x-small; font-weight: bold;">
                                            <strong class='text-error'><?php echo $usuarioEvaluador['cargo'];?>: </strong><?php echo $usuarioEvaluador['nom_usuario'] . ' ' . $usuarioEvaluador['ape_usuario'];?><br/>
                                            <strong class='text-error'>Gerente P&uacute;blico: </strong><?php echo $usuarioJefe['nom_usuario'] . ' ' . $usuarioJefe['ape_usuario'];?>
                                        </td>
                                    </tr>
                                </table>
			</td>
		</tr>
	</table>	

				
	<?php
		foreach ($macro as $lista):
			echo '<br>';
			echo '<table border="0" style="border-collapse: collapse; font-family:Helvetica, Arial, sans-serif;" width="90%" >';
			echo "<tr >";
			echo "<td colspan=10 style='background-color: #BFBFBF; border: 1px black solid; text-align: center; font-weight: bold;'>";
			echo strtoupper(utf8_decode($lista->MACROPROCESO)) . "<br>Peso Asignado : " . $lista->PESO_ASIGNADO . " </td>";
			echo "</tr>";

			//lista de compromisos programados
			$info_compromisos = $this->consultas_eval_model->get_asignacion_compromiso($lista->ID_ASIGNAR_MACRO);
//pr($info_compromisos);
			if($info_compromisos)
			{ 
	?>
				<tr >
					<td colspan=6 style="text-align: center; border: 1px black solid;">CONCERTACI&Oacute;N DE COMPROMISOS</td>
					<td colspan=3 style="text-align: center; border: 1px black solid;">SEGUIMIENTO Y EVALUACI&Oacute;N</td>
					<td rowspan=2 style="text-align: center; border: 1px black solid;" >CALIFICACI&Oacute;N</td> 
				</tr>
				<tr >
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >PILAR ESTRAT&Eacute;GICO</td>
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >DEFINICI&Oacute;N DEL PILAR ESTRAT&Eacute;GICO</td>
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >COMPROMISOS INSTITUCIONALES</td>
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >PESO</td>
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >RESTULTADO ESPERADO</td>
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >INDICADOR Y/O EVIDENCIA RESULTADO</td>
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >ABRIL</td>
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >AGOSTO</td>
					<td style="border: 1px black solid; text-align: center; font-size: 10px; font-weight: bold;" >DICIEMBRE</td>
				</tr>	
<?php
				foreach ($info_compromisos as $datos):
					echo '<tr><td style="vertical-align: middle; border: 1px black solid; font-size: 6px;" >' . utf8_decode($datos["PILAR"]) . '</td>';
					echo '<td style="vertical-align: middle; border: 1px black solid; font-size: 6px;" >' . utf8_decode($datos["DEFINICION_PILAR"]) . '</td>';
					echo '<td style="vertical-align: middle; border: 1px black solid; font-size: 6px;" >' . utf8_decode($datos["COMPROMISO"]) . '</td>';
					echo '<td style="vertical-align: middle; text-align: center; border: 1px black solid; font-size: 6px;" >' . $datos["PESO_PILAR"] . '</td>';
					echo '<td style="vertical-align: middle; text-align: center; border: 1px black solid; font-size: 6px;" >';
					if($datos['RESULTADO_ESPERADO']==1){ echo "Nominal"; }else{ echo "Porcentual"; }
					echo '</td>';
					echo '<td style="vertical-align: middle; text-align: center; border: 1px black solid; font-size: 6px;" >' . utf8_decode($datos["INDICADOR"]) . '</td>';					
					echo '<td style="text-align: center; border: 1px black solid; font-size: 6px;" >';
					if(isset($datos['ESPERADO_ABRIL']) && $datos['ESPERADO_ABRIL'] != 0 )
					{
						echo "<strong>Esperado: </strong><br>" . $datos['ESPERADO_ABRIL'] . "</p>";
						echo "<br>";
						if(isset($datos['SEGUIMIENTO_ABRIL']))
						{
							echo "<strong>SEGUIMIENTO</strong>";
							echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEGUIMIENTO_ABRIL'];//Cumplimiento
							echo "<br><strong>Avance:</strong><br>" . utf8_decode($datos['AVANCE_ABRIL']) . "</p>";
							echo "<br>";
							if($datos['APROBAR_ABRIL'] == 1){
								echo "<strong>APROBADO</strong>";//Aprobado
							}elseif($datos['APROBAR_ABRIL'] == 2){
								echo "<strong>DESAPROBADO</strong>";//Desaprobado
								echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEG_EVALUADOR_ABRIL'];
								echo "<br><strong>Observaci&oacute;n:</strong><br>" . utf8_decode($datos['OBS_EVALUADOR_ABRIL']);
							}
						}
					}else{echo "----";}
					echo "</td>";
					echo '<td style="text-align: center; border: 1px black solid; font-size: 6px;" >';
					if(isset($datos['ESPERADO_AGOSTO']) && $datos['ESPERADO_AGOSTO'] != 0 )
					{
						echo "<strong>Esperado: </strong><br>" . $datos['ESPERADO_AGOSTO'] . "</p>";
						echo "<br>";
						if(isset($datos['SEGUIMIENTO_AGOSTO']))
						{
							echo "<strong>SEGUIMIENTO</strong>";
							echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEGUIMIENTO_AGOSTO'];//Cumplimiento
							echo "<br><strong>Avance:</strong><br>" . utf8_decode($datos['AVANCE_AGOSTO']) . "</p>";
							echo "<br>";
							if($datos['APROBAR_AGOSTO'] == 1){
								echo "<strong>APROBADO</strong>";//Aprobado
							}elseif($datos['APROBAR_AGOSTO'] == 2){
								echo "<strong>DESAPROBADO</strong>";//Desaprobado
								echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEG_EVALUADOR_AGOSTO'];
								echo "<br><strong>Observaci&oacute;n:</strong><br>" . utf8_decode($datos['OBS_EVALUADOR_AGOSTO']);
							}
						}
					}else{echo "----";}
					echo "</td>";
					echo '<td style="text-align: center; border: 1px black solid; font-size: 6px;" >';
					if(isset($datos['ESPERADO_DICIEMBRE']) && $datos['ESPERADO_DICIEMBRE'] != 0 )
					{
						echo "<strong>Esperado: </strong><br>" . $datos['ESPERADO_DICIEMBRE'] . "</p>";
						echo "<br>";
						if(isset($datos['SEGUIMIENTO_DICIEMBRE']))
						{
							echo "<strong>SEGUIMIENTO</strong>";
							echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEGUIMIENTO_DICIEMBRE'];//Cumplimiento
							echo "<br><strong>Avance:</strong><br>" . utf8_decode($datos['AVANCE_DICIEMBRE']) . "</p>";
							echo "<br>";
							if($datos['APROBAR_DICIEMBRE'] == 1){
								echo "<strong>APROBADO</strong>";//Aprobado
							}elseif($datos['APROBAR_DICIEMBRE'] == 2){
								echo "<strong>DESAPROBADO</strong>";//Desaprobado
								echo "<br><strong>Cumplimiento: </strong><br>" . $datos['SEG_EVALUADOR_DICIEMBRE'];
								echo "<br><strong>Observaci&oacute;n:</strong><br>" . utf8_decode($datos['OBS_EVALUADOR_DICIEMBRE']);
							}
						}
					}else{echo "----";}
					echo "</td>";
					echo '<td style="vertical-align: middle; text-align: center; border: 1px black solid; font-size: 6px;" >';
					if($datos['CALIFICACION']){
						echo $datos['CALIFICACION'];
					}
					echo "</td>";
					echo '</tr>';
				endforeach;	
			}
			else
			{
				echo "<tr >";
				echo "<td colspan=10>Falta asignar los compromisos para este Macroproceso</td>";
				echo "</tr>";
			}
			echo "</table>";
		endforeach;
	?>


    </div> 
</div>

</body>
</html>