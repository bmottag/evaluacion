<div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="list-group-item-heading">
                   Foto de Perfil
                </h4>
            </div>
        </div>	
    <div class="well">
        <form  name="formGeneral" id="formGeneral" role="form" method="post" enctype="multipart/form-data" action="<?php echo site_url("/usuarios/do_upload"); ?>">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Ajuntar Foto:</label>
                    <input type="file" name="userfile" />

		</div>				
            </div>
            <div class="row" align="center">
                <div style="width:50%;" align="center">
                    <input type="submit" id="btnSubir" name="btnSubir" value="Subir Imagen" class="btn btn-primary"/>
                </div>
            </div>
            <br /><br />
            <div class="row">
                <div class="form-group col-md-12">
                    <?php if($error){ ?>
                    <div class="alert alert-danger">
                        <?php 
                            echo "<strong>ERROR :</strong>";
                            pr($error); 
                        ?><!--$ERROR MUESTRA LOS ERRORES QUE PUEDAN HABER AL SUBIR LA IMAGEN-->
                    </div>
                    <?php } ?>
                    <div class="alert alert-danger">
                            <strong>Tener en cuenta :</strong><br>
                            Formato permitido : gif - jpg - png<br>
                            Tamaño máximo : 2048 KB<br>
                            Ancho máximo : 1024 píxeles<br>
                            Altura máxima : 1008 píxeles<br>

                    </div>
		</div>				
            </div>            
	
        </form>
    </div>
</div>