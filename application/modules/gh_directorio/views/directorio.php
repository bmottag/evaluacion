<div class="container-fluid">
    <div class="page-header">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="list-group-item-heading">DIRECTORIO INSTITUCIONAL</h4>
            </div>
        </div>
    </div>
    <?php if ($msj != '') { ?>
        <!-- Mensaje del controlador -->
        <div id="divMsgAlert" class="alert alert-danger" style="text-align: center;" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong id="msgError">Nota: <?= $msj ?></strong>
            <br /><br /><a id="btnRegresar" name="btnRegresar" href="<?=base_url('gh_directorio')?>" class="btn btn-danger">Regresar</a>
        </div>
        <!-- FIN Mensaje del controlador -->
    <?php } else { ?>	
        <div class="row">
            <div class="col-md-12">	

                <table class="table table-bordered table-striped table-hover table-condensed">
                    <tr class="info">
                        <td class="text-center" style="font-weight: bold;">Nombres</td>
                        <td class="text-center" style="font-weight: bold;">Apellidos</td>
                        <td class="text-center" style="font-weight: bold;">Teléfono </td>
                        <td class="text-center" style="font-weight: bold;">Ext.</td>
                        <td class="text-center" style="font-weight: bold;">Correo </td>
                        <td class="text-center" style="font-weight: bold;">Despacho</td>
                        <td class="text-center" style="font-weight: bold;">Dependencia</td>
                        <td class="text-center" style="font-weight: bold;">Grupo</td>
                    </tr>
                    <?php
                    foreach ($directorio as $item):
                        echo "<tr>";
                        echo "<td ><small>" . strtoupper($item['NOM_USUARIO']) . "</small></td>";
                        echo "<td ><small>" . strtoupper($item['APE_USUARIO']) . "</small></td>";
                        echo "<td class='text-center'><small>" . $item['TEL_USUARIO'] . "</small></td>";
                        echo "<td class='text-center'><small>" . $item['EXT_USUARIO'] . "</small></td>";
                        echo "<td ><small>" . $item['MAIL_USUARIO'] . "</small></td>";
                        echo "<td ><small>";
                        $idDespacho = substr($item['CODIGO_DEPENDENCIA'], 0, 1);
                        for ($i = 0; $i < count($despacho); $i++) {
                            if ($despacho[$i]["id_dependencia"] == $idDespacho) {
                                echo $despacho[$i]["nom_dependencia"];
                            }
                        }
                        echo "</small></td>";
                        echo "<td ><small>";
                        $idDendencia = substr($item['CODIGO_DEPENDENCIA'], 0, 2);
                        for ($i = 0; $i < count($dependencias); $i++) {
                            if ($dependencias[$i]["id_dependencia"] == $idDendencia) {
                                echo $dependencias[$i]["nom_dependencia"];
                            }
                        }
                        echo "</small></td>";
                        echo "<td ><small>" . $item['DESCRIPCION'] . "</small></td>";
                        echo "</tr>";
                    endforeach
                    ?>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <ul class="pagination">
                                <?php echo $links; ?>
                            </ul>
                        </nav>		
                    </div>
                </div>			
            </div>				
        </div>
<?php } ?>
</div>