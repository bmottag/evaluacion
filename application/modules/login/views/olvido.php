	<script type="text/javascript" src="<?php echo base_url("js/login/login.js"); ?>"></script>
	<h2>Recordar Usuario y/o Contrase&ntilde;a</h2>    
    <div class="row">
    	<div class="col-md-12">
			<form role="form" method="post" action="<?php echo site_url("login/login/mailRecordar"); ?>">  				
  				<div class="row">
	  				<div class="form-group col-md-6">
	    				<label for="txtEmail">Correo Electr&oacute;nico</label>
	    				<input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Correo Electr&oacute;nico DANE" required>
	  				</div>
  				</div> 
  				<div class="row">
					<div id="result" class="form-group col-md-12">
	  					<button type="submit" id="btnRecordar" name="btnRecordar" class="btn btn-danger">Recordar mi usuario y contrase&ntilde;a</button>
	  				</div>
  				</div>
			</form>    		
    	</div>    	
    </div>
    