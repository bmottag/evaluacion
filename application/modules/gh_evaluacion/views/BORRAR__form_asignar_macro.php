    <div class="container">	
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="list-group-item-heading">
                            ASIGNAR MACROPROCESO: 
                            <?php
                            echo $idOficina
                            ?>
                        </h4>
                    </div>
                </div>
            </div>			
        </div>
		
        <div class="well">
            <form  name="formModulos" id="formModulos" role="form" method="post" >
                <?php
                echo '<input type="hidden" name="idUser" value="' . $idOficina . '" />';
                ?>		
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped table-hover table-condensed table-bordered">
				<tr class="info">
					<td ><p class="text-center"><strong>Check</strong></p></td>
					<td ><p class="text-center"><strong>M&oacute;dulo</strong></p></td>
					<td ><p class="text-center"><strong>Perfil - Permiso </strong></p></td>
					<td ><p class="text-center"><strong>Descripci&oacuten </strong></p></td>
				</tr>
				<?php 
				//$ci = &get_instance();
				//$ci->load->model("menu_model");
                                
                               

                                
                                
				foreach ($macropoceso as $lista):
					//$permiso = $ci->menu_model->get_relacion_permisos($idUser, $lista['ID_PERMISO']);
					
					echo "<tr>";
					echo "<td>";
					
					$data = array(
						'name' => 'perfil[]',
						'id' => 'perfil',
						'value' => $lista->ID_MACROPROCESO,
						//'checked' => $permiso,
						'style' => 'margin:10px'
					);
					echo form_checkbox($data);					
					
					echo "</td>";
					echo "<td><small>" . $lista->MACROPROCESO. "</small></td>";
                                        echo '<td><small><input type="text" name="peso[]" id="peso[]" class="form-control" placeholder="Peso"  /></small></td>';

                                        
                                        
                                        
                                        
                                        
					echo "</tr>";
				endforeach ?>
			</table>
		</div>
	</div>


                <div class="row">
                    <div class="col-md-6"><br>
                        <input class="btn btn-primary" type="submit" name="Button" value="Actualizar permisos" >
                    </div>
                </div>				
            </form>
        </div>
    </div>