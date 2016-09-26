<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
        <td><p class="text-center"><strong>Tipo l&uacute;dica</strong></p></td>
        <td><p class="text-center"><strong>Actividad</strong></p></td>
        <td><p class="text-center"><strong>Cu&aacute;l</strong></p></td>
        <td><p class="text-center"><strong>Horas al mes</strong></p></td>
        <td><p class="text-center"><strong>Opci&oacute;n</strong></p></td>
    </tr>
    <?php
    foreach ($actividad as $lista):
        echo "<tr>";
        echo "<td class='text-right'>" . $lista['TIPO_LUDICA'] . "</td>";
        echo "<td class='text-right'>" . $lista['LUDICA'] . "</td>";
        echo "<td class='text-right'>" . $lista['CUAL'] . "</td>";
        echo "<td class='text-right'>" . $lista['HORAS'] . "</td>";
        echo "<td class='text-center'>";
        echo "<a class='btn btn-danger' href='" . base_url() . "usuarios/eliminarActividad/" . $lista['ID_ACTIVIDAD'] . "'>Eliminar <span class='glyphicon glyphicon-trash' aria-hidden='true'></a>";
        echo "&nbsp;<a class='btn btn-success' href='" . base_url() . "usuarios/actividades/" . $lista['ID_ACTIVIDAD'] . "'>Editar <span class='glyphicon glyphicon-pencil' aria-hidden='true'></a>";
        echo "</td>";
        echo "</tr>";
    endforeach;
    ?>
</table>