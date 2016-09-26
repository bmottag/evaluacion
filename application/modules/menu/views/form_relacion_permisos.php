<script type="text/javascript" src="<?php echo base_url("js/menu/usuarios.js"); ?>"></script>	

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                ASIGNAR PERMISO AL USUARIO
            </h4>
        </div>
    </div>
		<div class="alert alert-info" role="alert">
			<strong>Nota: </strong>Buscar usuario por número de cédula, para ver los permisos actuales y actualizarlos.
		</div>
    <div class="well">
        <div class="row">
            <div class="form-group col-md-2">
                <label>N&uacute;mero de c&eacute;dula</label>
                <input type="text" id="txtCedula" name="txtCedula" value="<?php echo (isset($identifica)) ? $identifica : ""; ?>" class="form-control" placeholder="N&uacute;mero de C&eacute;dula"  required autofocus />
                <input type="hidden" id="regreso" name="regreso" value="<?php echo $regreso; ?>" >
            </div>
            <div class="form-group col-md-10" id="nombres"></div>	
        </div>	
    </div>

<?php if ($usuario != '') { ?>	
    <div id="infoPermisos">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="list-group-item-heading">
                            <?php
                            $idUser = $usuario["id"];
                            echo $usuario["nom_usuario"] . ' ' . $usuario["ape_usuario"]
                            ?> - RELACI&Oacute;N DE PERMISOS
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="well">
            <form  name="formModulos" id="formModulos" role="form" method="post" >
                <?='<input type="hidden" name="idUser" value="' . $idUser . '" />';?>
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
                            $ci = &get_instance();
                            $ci->load->model("menu_model");
                            foreach ($perfiles as $lista):
                                $permiso = $ci->menu_model->get_relacion_permisos($idUser, $lista['ID_PERMISO']);
                            
                                echo "<tr>";
                                echo "<td>";

                                $data = array(
                                    'name' => 'perfil[]',
                                    'id' => 'perfil',
                                    'value' => $lista['ID_PERMISO'],
                                    'checked' => $permiso,
                                    'style' => 'margin:10px'
                                );
                                echo form_checkbox($data);

                                echo "</td>";
                                echo "<td><small>" . $lista['NOMBRE_MODULO'] . "</small></td>";
                                echo "<td><small><span class='label label-primary'>" . $lista['PERFIL'] . "</span> - " . $lista['NOMBRE_PERMISO'] . "</small></td>";
                                echo "<td><small>" . $lista['DESCRIPCION'] . "</small></td>";
                                echo "</tr>";
                            endforeach
                            ?>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"><br>
                        <input class="btn btn-primary" type="submit" name="Button" value="Actualizar permisos" />
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
</div>