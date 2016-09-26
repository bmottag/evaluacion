<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
        <td><p class="text-center"><strong>Mascota</strong></p></td>
        <td><p class="text-center"><strong>Cu&aacute;l</strong></p></td>
        <td><p class="text-center"><strong>Cuantos</strong></p></td>
        <td><p class="text-center"><strong>Opci&oacute;n</strong></p></td>
    </tr>
    <?php
    foreach ($mascota as $lista):
        $html = "<tr>";
        $html .= "<td >";
        switch ($lista['MASCOTA']) {
            case 1:
                $html .= "Gatos";
                break;
            case 2:
                $html .= "Perros";
                break;
            case 3:
                $html .= "Otro";
                break;
            case 99:
                $html .= "Ninguno";
                break;
        }
        $html .= "</td>";
        $html .= "<td >" . $lista['CUAL'] . "</td>";
        $html .= "<td class='text-center'>" . $lista['CUANTOS'] . "</td>";
        $html .= "<td class='text-center'>";
        $html .= "<a class='btn btn-danger' href='" . base_url() . "usuarios/eliminarMascota/" . $lista['ID_MASCOTA'] . "'>Eliminar <span class='glyphicon glyphicon-trash' aria-hidden='true'></a>";
        if($lista['MASCOTA']!=99){
			$html .= "&nbsp;<a class='btn btn-success' href='" . base_url() . "usuarios/mascotas/" . $lista['ID_MASCOTA'] . "'>Editar <span class='glyphicon glyphicon-pencil' aria-hidden='true'></a>";
		}
        $html .= "</td>";
        $html .= "</tr>";
        echo $html;
    endforeach;
    ?>
</table>