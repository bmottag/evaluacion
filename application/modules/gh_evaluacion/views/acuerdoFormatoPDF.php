<html>
    <head>
        <title>Formato del Acuerdo</title>

        <style type="text/css">
            div.special { margin: auto; width:83%; text-align: justify; padding: 0 0 35px; }


            body{
                height:100%; margin:0;
                font-family:12px Helvetica, Arial, sans-serif;
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
                <h3>
                    ACUERDO DE GESTI&Oacute;N
                </h3>
                <div class="special">
                    <p>
                        En la ciudad de <strong>Bogot&aacute;</strong> a los <strong>____</strong> d&iacute;as del mes de <strong>____________</strong> 
                        de <strong>________</strong> se re&uacute;nen <strong><?php echo $usuarioEvaluador['nom_usuario'] . ' ' . $usuarioEvaluador['ape_usuario'];?></strong> titular del cargo <strong><?php echo $usuarioEvaluador['cargo'];?> de Departamento</strong> 
                        en adelante superior jer&aacute;rquico, y <strong><?php echo $usuarioJefe['nom_usuario'] . ' ' . $usuarioJefe['ape_usuario'];?></strong> en adelante gerente p&uacute;blico, a efectos de suscribir 
                        el presente ACUERDO DE GESTI&Oacute;N.
                    </p>
                    <p>
                        Las partes que suscriben este acuerdo lo hacen entendiendo que este instrumento constituye una forma de evaluar la gesti&oacute;n con base en los compromisos 
                        asumidos por el &aacute;rea <strong><?php echo $acuerdo[0]->DESCRIPCION;?></strong> respecto al logro de resultados y en las habilidades gerenciales requeridas.
                    </p>
                    <p>
                        Las cl&aacute;usulas que regir&aacute;n el presente ACUERDO son:<br>
                        PRIMERA: El ACUERDO implica la voluntad expresa del gerente p&uacute;blico de trabajar permanentemente por el mejoramiento continuo de los procesos y asegurar 
                        la transparencia y la calidad de los productos encomendados.
                    </p>
                    <p>
                        SEGUNDA: El gerente p&uacute;blico se compromete durante el lapso de vigencia del presente ACUERDO, a alcanzar los resultados que se detallan en el formato anexo, 
                        el cual hace parte constitutiva de este ACUERDO; asimismo se compromete a poner a disposici&oacute;n de la entidad sus habilidades t&eacute;cnicas y gerenciales para 
                        contribuir al logro de los objetivos institucionales.
                    </p>
                    <p>
                        TERCERA: El superior jer&aacute;rquico se compromete a apoyar al gerente p&uacute;blico para adelantar los compromisos pactados en este ACUERDO.
                    </p>
                    <p>
                        CUARTA: Cuando se trate de proyectos financiados con recursos de inversi&oacute;n, la concreci&oacute;n de los compromisos asumidos por el gerente p&uacute;blico en el presente 
                        ACUERDO quedar&aacute; sujeta a la disponibilidad de los recursos presupuestarios necesarios para la ejecuci&oacute;n de los mismos. En caso de no tener disponibles los 
                        recursos, en conjunto con el superior jer&aacute;rquico se buscar&aacute;n alternativas de financiaci&oacute;n, cofinanciaci&oacute;n, redistribuci&oacute;n o traslado entre programas, 
                        proyectos o componentes de proyecto.
                    </p>
                    <p>
                        QUINTA: El presente ACUERDO ser&aacute; objeto de una evaluaci&oacute;n al finalizar la vigencia y de seguimiento permanente.  Dicha evaluaci&oacute;n y seguimiento se realizar&aacute;n 
                        sobre la base de indicadores de calidad, oportunidad y cantidad; las habilidades gerenciales ser&aacute;n objeto de retroalimentaci&oacute;n cualitativa por parte del 
                        evaluador, para lo cual se utilizar&aacute; el Formato de Evaluaci&oacute;n que hace parte constitutiva de este ACUERDO.
                    </p>
                    <p>
                        SEXTA: Medios de Verificaci&oacute;n.  Para la evaluaci&oacute;n y el seguimiento del presente ACUERDO se utilizar&aacute;n como medios de verificaci&oacute;n, los Planes Operativos o de 
                        Gesti&oacute;n Anual de la entidad, los informes de evaluaci&oacute;n de los mismos elaborados durante la vigencia por las oficinas de planeaci&oacute;n y de control interno y los 
                        resultados de la evaluaci&oacute;n del Sistema de Planeaci&oacute;n y Gesti&oacute;n Institucional SPGI. 
                    </p>
                    <p>
                        S&Eacute;PTIMA: Las partes suscriben el presente ACUERDO DE GESTI&Oacute;N por un periodo de ____ meses desde el ____ de ____________ de ________ hasta el ____ 
                        de ____________ de ________.
                    </p>
                    <p>
                        OCTAVA: El presente ACUERDO DE GESTI&Oacute;N podr&aacute; ser ajustado o modificado de com&uacute;n acuerdo entre las partes.
                    </p>
                    <p>
                        NOVENA: En prueba de conformidad se firma el ACUERDO DE GESTI&Oacute;N:
                    </p>
    
                </div>
            </div> 
        </div>
        <div id="footer">
            <div class="special">
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