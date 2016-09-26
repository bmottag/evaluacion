<script type="text/javascript" src="<?php echo base_url("js/login/login.js"); ?>"></script>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">CREACI&OACUTE;N DE USUARIOS</h4>
        </div>
    </div>
    <div class="well">
        <form role="form" method="post" action="">
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="txtIdentificacion">Nro. Identificaci&oacute;n</label>
                    <input type="text" id="txtIdentificacion" name="txtIdentificacion" maxlength="12" class="form-control" placeholder="N&uacute;mero de C&eacute;dula" required autofocus>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-5">
                    <label for="txtNombres">Nombres</label>
                    <input type="text" id="txtNombres" name="txtNombres" maxlength="50" class="form-control" placeholder="Nombres" required autofocus>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-5">
                    <label for="txtApellidos">Apellidos</label>
                    <input type="text" id="txtApellidos" name="txtApellidos" maxlength="50" class="form-control" placeholder="Apellidos" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-5">
                    <label for="txtEmail">Correo Electr&oacute;nico</label>
                    <input type="email" id="txtEmail" name="txtEmail" maxlength="100" class="form-control" placeholder="Correo Electr&oacute;nico DANE" required>
                </div>
            </div>
            <!-- 
            <div class="row">
                    <div class="form-group col-md-3">
                    <label for="cmbTipoUsuario">Tipo de Usuario</label>
                    <select id="cmbTipoUsuario" name="cmbTipoUsuario" class="form-control">
                               <option value="-">Seleccione...</option>
                               <option value="1">Funcionario de Planta</option>
                               <option value="2">Contratista</option>  
                            </select>
                    </div>
            </div>
            -->	 
            <br/> 			
            <div class="row">	  				
                <div id="result" class="form-group col-md-4">
                    <button type="button" id="btnCrearUsuario" name="btnCrearUsuario" class="btn btn-primary">Crear Usuario</button>
                </div>
            </div>	
        </form>
    </div>
</div>