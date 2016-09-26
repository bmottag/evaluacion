<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
            <td><p class="text-center"><strong>Dependencia / Grupo</strong></p></td>
            <td><p class="text-center"><strong>Jefe</strong></p></td>
            <td><p class="text-center"><strong>Cargo</strong></p></td>
    </tr>
<?php
    foreach ($info as $lista):
                    echo "<tr>";
                    echo "<td>" . $lista->DESCRIPCION . "</td>";
                    echo "<td>" . $lista->JEFE . "</td>";
                    echo "<td>";
                        switch ($lista->CARGO) {
                                case 1:
                                        echo "Director";
                                        break;
                                case 2:
                                        echo "Jefe";
                                        break;
                                case 3:
                                        echo "Coordinador";
                                        break;
                        }
                    echo "</td>";
                    echo "</tr>";		
    endforeach;
?>
</table>