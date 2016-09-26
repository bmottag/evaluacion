<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
            <td ><p class="text-center"><strong>Parentesco</strong></p></td>
            <td ><p class="text-center"><strong>Nombre</strong></p></td>
            <td ><p class="text-center"><strong>Sexo</strong></p></td>
            <td ><p class="text-center"><strong>Nro. Identificaci&oacute;n</strong></p></td>
            <td ><p class="text-center"><strong>Fecha Nacimiento</strong></p></td>
            <td ><p class="text-center"><strong>Opci&oacute;n</strong></p></td>
    </tr>
<?php
    foreach ($dependientes as $lista):
                            echo "<tr>";
                            echo "<td >";
                                switch ($lista['PARENTESCO']) {
                                                case 1:
                                                                echo "Conyuge";
                                                                break;
                                                case 2:
                                                                echo "Hijo";
                                                                break;
                                                case 3:
                                                                echo "Hermano";
                                                                break;
                                                case 4:
                                                                echo "Madre";
                                                                break;
                                                case 5:
                                                                echo "Padre";
                                                                break;
                                                case 6:
                                                                echo "Nieto";
                                                                break;
                                                case 99:
                                                                echo "Ninguno";
                                                                break;
							}
                            echo "</td>";
                            echo "<td >" . $lista['NOM_DEPENDIENTE'] . ' ' . $lista['APE_DEPENDIENTE'] . "</td>";
                            echo "<td class='text-center'>" . $lista['SEXO'] . "</td>";
                            echo "<td >" . $lista['TIPO_DOCUMENTO'] . '. ' . $lista['NUM_IDENT_DEP'] . "</td>";
                            echo "<td class='text-center'>" . $lista['FECHA_NACIMIENTO'] . "</td>";
                            echo "<td class='text-center'>";
                            echo "<a class='btn btn-danger' href='" . base_url() . "usuarios/eliminarDependiente/" . $lista['ID_DEPENDIENTE'] . "'>Eliminar <span class='glyphicon glyphicon-trash' aria-hidden='true'></a>";
                                if($lista['PARENTESCO']!=99){
                                        echo "&nbsp;<a class='btn btn-success' href='" . base_url() . "usuarios/dependientes/" . $lista['ID_DEPENDIENTE'] . "'>Editar <span class='glyphicon glyphicon-pencil' aria-hidden='true'></a>";
                                }
                            echo "</td>";                            
                            echo "</tr>";		
    endforeach;
?>
</table>