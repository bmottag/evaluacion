<table class="table table-bordered table-striped table-hover table-condensed">
    <tr class="info">
                <td><p class="text-center"><strong>Dependencia / Territorial</strong></p></td>
                <td><p class="text-center"><strong>Tipo Gerente P&uacute;blico</strong></p></td>
				<td><p class="text-center"><strong>Evaluador</strong></p></td>
                <td><p class="text-center"><strong>Estado </strong></p></td>
				<td><p class="text-center"><strong>Editar </strong></p></td>
    </tr>
<?php
            foreach ($informacion as $lista):
                    echo "<tr>";
                    echo "<td ><small>" . $lista['DESCRIPCION'] . "</small></td>";
					echo "<td class='text-center'><small>";
					switch ($lista['TIPO_GERENTE_PUBLICO']) {
							case 1:
									echo "DRIRECCIONES TERRITORILES";
									break;
							case 2:
									echo "NIVEL CENTRAL";
									break;
					}
					echo "</small></td>";
                    echo "<td class='text-center'><small>";
                    switch ($lista['EVALUADOR']) {
                            case 1:
                                echo "Director";
                                break;
                            case 2:
                                echo "Subdirector";
                                break;
                    }						
                    echo "</small></td>";
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
                    $enlace = site_url().'gh_evaluacion/admin_evaluacion/oficina/' .$lista['ID_OFICINA'];
                    echo '<a class="btn btn-primary" href="' . $enlace . '">EDITAR <span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span></a>';
                    echo "</td>";					
                    echo "</tr>";
            endforeach;
?>
</table>