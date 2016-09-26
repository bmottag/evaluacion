<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
        <td class="text-center" style='font-weight: bold;'>Nivel de Estudios</td>
        <td class="text-center" style='font-weight: bold; width: 24%;'>T&iacute;tulo Obtenido</td>
        <td class="text-center" style='font-weight: bold;'>&Aacute;rea de conocimiento</td>
        <td class="text-center" style='font-weight: bold; width: 8%;'>Graduado</td>
        <td class="text-center" style='font-weight: bold; width: 8%;'>A&ntilde;o Finalizaci&oacute;n</td>
        <td class="text-center" style='font-weight: bold; width: 18%;'>Opci&oacute;n</td>
    </tr>
    <?php
    foreach ($academica as $lista):
        echo "<tr>";
        echo "<td >" . $lista['NIVEL_ESTUDIO'] . "</td>";
        echo "<td >" . $lista['TITULO'] . "</td>";
        echo "<td class='text-center'>" . $lista['AREA_CONOCIMIENTO'] . "</td>";
        echo "<td class='text-center'>";
        switch ($lista['GRADUADO']) {
            case 1:
                echo "Si";
                break;
            case 2:
                echo "No";
                break;
            default:
                echo "";
        }
        echo "</td>";
        echo "<td class='text-center'>" . $lista['ANNO'] . "</td>";
        echo "<td class='text-center'>";
        echo "<a class='btn btn-danger' href='" . base_url() . "usuarios/eliminarAcademica/" . $lista['ID_ACADEMICA'] . "'>Eliminar <span class='glyphicon glyphicon-trash' aria-hidden='true'></a>";
        if ($lista['FK_ID_ESTUDIO'] != 99) {
            echo "&nbsp;<a class='btn btn-success' href='" . base_url() . "usuarios/academica/" . $lista['ID_ACADEMICA'] . "'>Editar <span class='glyphicon glyphicon-pencil' aria-hidden='true'></a>";
        }
        echo "</td>";
        echo "</tr>";
    endforeach;
    ?>
</table>