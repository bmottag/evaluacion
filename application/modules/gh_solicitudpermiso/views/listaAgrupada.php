<!-- Contenido -->	
<div class="container">
    <table class="table table-bordered table-striped table-hover table-condensed">
        <tr class="info">
            <td colspan="11"><h1 align="center">N�mero de permisos aprobados por funcionario</h1>
            </td>
        </tr>
        <tr class="info">
            <td colspan="5">
                <?php
                if ($fecha_permiso != 'x') {
                    echo "<strong>Filtrado por dependencia: </strong>" . $fecha_permiso;
                }
                if ($estado != 'x') {
                    echo "<strong>Filtrado por estado de la solicitud: </strong>" . $estado;
                }
                ?>			
            </td>
        </tr>
        <tr><td><p></p></td></tr>
        <tr class="info">
            <td ><p class="text-center"><strong>Funcionario</strong></p></td>
            <td ><p class="text-center"><strong>Dependencia</strong></p></td>
            <td ><p class="text-center"><strong>Numero de permisos aprobados</strong></p></td>
        </tr>
        <?php
        //var_dump($solicitudes);
        foreach ($solicitudes as $data):
            echo "<tr>";
            echo "<td>" . $data['completo'] . "</td>";
            echo "<td>" . $data['dependencia'] . "</td>";
            echo "<td>" . $data['cuenta'] . "</td>";
            echo "</tr>";
        endforeach
        ?>
    </table>
</div>