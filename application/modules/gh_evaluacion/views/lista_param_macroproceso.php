<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
        <td><p class="text-center"><strong>Área</strong></p></td>
        <td><p class="text-center"><strong>Macroproceso</strong></p></td>
        <td><p class="text-center"><strong>Jefe</strong></p></td>
        <td><p class="text-center"><strong>Estado </strong></p></td>
        <td><p class="text-center"><strong>Editar </strong></p></td>
    </tr>
    <?php
    foreach ($informacion as $lista):
        echo "<tr>";
        echo "<td class='text-center'><small>" . $lista->AREA . "</small></td>";
        echo "<td ><small>" . $lista->MACROPROCESO . "</small></td>";
        echo "<td ><small>" . $lista->JEFE . "</small></td>";
        echo "<td class='text-center'>";
        if ($lista->ESTADO == 1) {
            $valor = 'Activo';
            $clase = "label label-success";
        } else {
            $valor = 'Bloqueado';
            $clase = "label label-danger";
        }
        echo '<h4><span class="' . $clase . '">' . $valor . '</span></h4>';
        echo "</td>";
        echo "<td class='text-center'>";
        $enlace = site_url() . 'gh_evaluacion/admin_evaluacion/macroproceso/' . $lista->ID_MACROPROCESO;
        echo '&nbsp;<a class="btn btn-primary" href="' . $enlace . '">EDITAR <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>';
        echo "</td>";
        echo "</tr>";
    endforeach;
    ?>
</table>