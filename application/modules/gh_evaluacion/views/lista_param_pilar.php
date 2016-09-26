<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
            <td><p class="text-center"><strong>Pilar</strong></p></td>
            <td><p class="text-center"><strong>Definici&oacute;n</strong></p></td>
            <td><p class="text-center"><strong>Estado </strong></p></td>
            <td><p class="text-center"><strong>Editar </strong></p></td>
    </tr>
<?php
        foreach ($informacion as $lista):
                echo "<tr>";
                echo "<td ><small>" . $lista['PILAR'] . "</small></td>";
                echo "<td ><small>" . $lista['DEFINICION_PILAR'] . "</small></td>";
				echo "<td class='text-center'>";
				if( $lista['ESTADO']==1){
					$valor = 'Activo';
					$clase = "label label-success";
				}else{
					$valor = 'Bloqueado';
					$clase = "label label-danger";
				}
				echo '<h4><span class="' . $clase . '">' . $valor . '</span></h4>';
				echo "</td>";
                echo "<td class='text-center'>";
                $enlace = site_url().'gh_evaluacion/admin_evaluacion/pilar/' .$lista['ID_PILAR'];
                echo '<a class="btn btn-primary" href="' . $enlace . '">EDITAR <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>';
                echo "</td>";
                echo "</tr>";
        endforeach;
?>
</table>