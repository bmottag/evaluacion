<!-- <script src="<?php //echo base_url("js/admin/ghumana/permisos.js");  ?> "></script>-->
<h3>Permisos de Usuario</h3>
<h5><?php echo $nombre_usuario; ?></h5>
<br /><br />
<form id="form_permisos" name="form_permisos">
    <table width="100%">
        <tr>
            <td width="40%">
                <table  class="table">
                    <?php
                    $nro = count($modulos);
                    $limit_a = ceil($nro / 2);
                    $limit_b = $limit_a + 1;
                    $limit_c = $nro;

                    for ($i = 1; $i <= $limit_a; $i++) {
                        ?>
                        <tr>
                            <td width="10%">
                                <input type="checkbox" id="modulo[1]"   name="modulo[]"  value="<?php echo $modulos[$i]["id"]; ?>" <?php echo in_array($modulos[$i]["id"], $permisos) ? "checked='checked'" : ""; ?> >
                                <!-- <input type="checkbox" id="modulo[2]"   name="modulo[]"  value="2"  disabled> -->
                            </td>
                            <td>
                                <label> <?php echo $modulos[$i]["nombre"]; ?></label>
                            </td>
                        </tr>
                        <?php } ?>
                </table>	
            </td>
            <td width="10%"> &nbsp;</td>
            <td width="40%">
                <table class="table"
                    <?php for ($i = $limit_b; $i <= $limit_c; $i++) { ?>
                    <tr>
                     <td width="10%">
                         <input type="checkbox" id="modulo[1]"   name="modulo[]"  value="<?php echo $modulos[$i]["id"]; ?>" <?php echo in_array($modulos[$i]["id"], $permisos) ? "checked='checked'" : ""; ?> >
                     </td>
                     <td>
                         <label> <?php echo $modulos[$i]["nombre"]; ?></label>
                     </td>
                 </tr>
                <?php } ?>
                </table>
            </td>
        </tr>
    </table>

    <div class="row" align="center">
        <div style="width:50%;" align="center">

            <div id="div_cargando" style="display:none">		

                <div class="progress progress-striped active">
                    <div class="progress-bar" role="progressbar"
                         aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"
                         style="width: 45%">
                        <span class="sr-only">45% completado</span>
                    </div>
                </div>
            </div>	
            <div id="div_guardado" style="display:none">			
                <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>

            </div>	
            <div id="div_error" style="display:none">			
                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
            </div>	

            <input type="button" id="btnGuardarPermisos" name="btnGuardarPermisos" value="Guardar" class="btn btn-primary"/>

        </div>
    </div>

    </br>
    <input type="hidden" name="id_usuario" id="id_usuario" />
</form>
<?php $prueba = '
<div class="panel panel-primary">

<div class="row">
	<div class="col-lg-6">
		<div class="input-group">
		
			<input type="checkbox" ><label> Permiso 1</label>
		</div><!-- /input-group -->
	</div><!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<div class="input-group">
		
			<input type="checkbox" ><label> Permiso 2</label>
		
		</div><!-- /input-group -->
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->


	<div class="row">
	<div class="col-lg-6">
		<div class="input-group">
		<span class="input-group-addon">
			<input type="checkbox" aria-label="...">
		</span>
		<label> Permiso 1</label>
		</div><!-- /input-group -->
	</div><!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<div class="input-group">
		<span class="input-group-addon">
			<input type="checkbox" aria-label="...">
		</span>
		<label> Permiso 1</label>
		</div><!-- /input-group -->
	</div><!-- /.col-lg-6 -->
	</div><!-- /.row -->

</div>';
?>