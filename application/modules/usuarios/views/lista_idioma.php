<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
        <td><p class="text-center"><strong>Idioma</strong></p></td>
        <td><p class="text-center"><strong>Cu&aacute;l</strong></p></td>
        <td><p class="text-center"><strong>Habla</strong></p></td>
        <td><p class="text-center"><strong>Lee</strong></p></td>
        <td><p class="text-center"><strong>Escribe</strong></p></td>
        <td><p class="text-center"><strong>Opci&oacute;n</strong></p></td>
    </tr>
<?php
    foreach ($idioma as $lista):
                    echo "<tr>";
                    echo "<td >" . $lista['IDIOMA'] . "</td>";
                    echo "<td class='text-right'>" . $lista['CUAL'] . "</td>";
                    echo "<td class='text-center'>";
                        switch ($lista['HABLA']) {
                                case 1:
                                        echo "Básico";
                                        break;
                                case 2:
                                        echo "Intermedio";
                                        break;
                                case 3:
                                        echo "Avanzado";
                                        break;
                                case 4:
                                        echo "Experto";
                                        break;
                                case 5:
                                        echo "Ninguno";
                                        break;                       
                        }
                    echo "</td>";

                    echo "<td class='text-center'>";
                        switch ($lista['LEE']) {
                                case 1:
                                        echo "Básico";
                                        break;
                                case 2:
                                        echo "Intermedio";
                                        break;
                                case 3:
                                        echo "Avanzado";
                                        break;
                                case 4:
                                        echo "Experto";
                                        break;
                                case 5:
                                        echo "Ninguno";
                                        break;                       
                        }
                    echo "</td>";
                    
                    echo "<td class='text-center'>";
                        switch ($lista['ESCRIBE']) {
                                case 1:
                                        echo "Básico";
                                        break;
                                case 2:
                                        echo "Intermedio";
                                        break;
                                case 3:
                                        echo "Avanzado";
                                        break;
                                case 4:
                                        echo "Experto";
                                        break;
                                case 5:
                                        echo "Ninguno";
                                        break;                       
                        }
                    echo "</td>";
                    echo "<td class='text-center'>";
                    echo "<a class='btn btn-danger' href='" . base_url() . "usuarios/eliminarIdioma/" . $lista['ID_USER_IDIOMA'] . "'>Eliminar <span class='glyphicon glyphicon-trash' aria-hidden='true'></a>";
                    echo "&nbsp;<a class='btn btn-success' href='" . base_url() . "usuarios/idiomas/" . $lista['ID_USER_IDIOMA'] . "'>Editar <span class='glyphicon glyphicon-pencil' aria-hidden='true'></a>";
                    echo "</td>";                            
                    echo "</tr>";		
    endforeach;
?>
</table>