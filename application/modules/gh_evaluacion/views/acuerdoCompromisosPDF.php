<html>
    <head>
        <meta charset="UTF-8">
        <title>Formato del Acuerdo</title>

        <style type="text/css">
            div.special { margin: auto; width:83%; text-align: justify; padding: 0 0 35px; }
            body{
                height:100%; margin:0;
                font-family: Helvetica, Arial, sans-serif;
                font-size: 12px;
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
                margin-bottom:702px;
            }            

            #cabecera{
                height: 80px;
                width: auto;
                padding:10px;
            }

            #footer {
                width: auto;
                height: 106px;
                padding: 20px 0;

                margin-top:-200px;
                -webkit-box-sizing:border-box;
                -moz-box-sizing:border-box;
                box-sizing:border-box;

            }        
        </style>
    </head>
    <body >

        <div id="cabecera">
            <div class="special">
                <table border="0" style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td width="25%"><img src='<?php echo $imagen; ?>'></td>
                        <td style="font-size: large; font-weight: bold; text-align: center;">
                            FORMATO ACUERDOS DE GESTI&Oacute;N<br>Gerentes P&uacute;blicos
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
            </div>
        </div>   

        <div id="conteiner">
            <div id="content">
                <table border="1" style="border-collapse: collapse;" width="100%">
                    <tr>
                        <td colspan=6 style="font-size: large; font-weight: bold; text-align: center;">
                            COMPROMISOS DE MEJORA GERENCIAL
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: medium; font-weight: bold; text-align: center;"colspan=2 rowspan=2>Competencias B&aacute;sicas Gerenciales</td>
                        <td style="font-size: medium; font-weight: bold; text-align: center;"rowspan=2>Indicadores<br>(S&iacute;ntesis de Conductas Asociadas)</td>
                        <td style="font-size: medium; font-weight: bold; text-align: center;"colspan=3>Necesidades Mejora Gerencial</td>
                    </tr>
                    <tr>
                        <td style="font-size: medium; font-weight: bold; text-align: center;">No se detectan</td>
                        <td style="font-size: medium; font-weight: bold; text-align: center;">Se detectan</td>
                        <td style="font-size: medium; font-weight: bold; text-align: center;">Son imprescindibles</td>
                    </tr>  
                    <?php
                    
                    foreach ($detalle as $datos):
                        echo "<tr>";
                        echo '<td style="font-size: small; font-weight: bold; text-align: center;"><small>' . $datos['COMPROMISO'] = utf8_decode($datos['COMPROMISO']) . '</small></td>';
                        echo "<td ><small>" . $datos['DESCRIPCION'] = utf8_decode($datos['DESCRIPCION']) . "</small></td>";
                        echo "<td ><small>" . $datos['INDICADORES'] = utf8_decode($datos['INDICADORES']) . "</small></td>";

                        for ($i = 1; $i <= 3; $i++) {
                            echo '<td style="font-size: small; text-align: center;">';
                            if (isset($datos['NECESIDAD_MEJORA']) && $i == $datos['NECESIDAD_MEJORA']) {
                                echo "X";
                            }
                            echo '</td>';
                        }
                        echo "</tr>";
                    endforeach;
                    ?>
                </table>
            </div> 
        </div>
        <div id="footer">
            <div class="special">
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
                <br><br>
                <table>
                    <tr>
                        <td style="text-align: justify;">
                            <strong>OBSERVACIONES:</strong>
                            <br><?php echo utf8_decode($acuerdo[0]->OBSERVACIONES); ?>
                        </td>
                    </tr>
                </table>
                <br><br>
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
                <br><br><br><br><br><br>
                <table width="100%">
                    <tr>
                        <td width="40%">_________________________</td>
                        <td></td>
                        <td width="40%">_________________________</td>
                    </tr>
                    <tr>
                        <td>Firma Superior Jer&aacute;rquico</td>
                        <td></td>
                        <td>Firma Gerente P&uacute;blico</td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>