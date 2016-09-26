<nav class="navbar navbar-default navbar-fixed-top">
	<!-- <div class="container">-->
    	<div class="navbar-header">
        	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            	<span class="sr-only">Toggle navigation</span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
          	</button>
          	<a class="navbar-brand" href="#">Administrador</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        	<ul class="nav navbar-nav">
        		<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Opciones<span class="caret"></span></a>
              		<ul class="dropdown-menu">
                		<li><a href="#">Usuarios</a></li>
                		<li><a href="#">Aplicaciones</a></li>
                		<li role="separator" class="divider"></li>                		
                		<li><a href="<?php echo site_url("/admin/salir"); ?>">Salir</a></li>                		
              		</ul>
            	</li>            	
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gesti&oacute;n Humana<span class="caret"></span></a>
              		<ul class="dropdown-menu">
                		<li><a href="#">Actos Administrativos</a></li>
                		<li><a href="<?php echo site_url("/admin/certificaciones"); ?>">Certificaciones</a></li>
                		<li><a href="#">Planta de Personal</a></li>
                		<li><a href="#">Vinculaci&oacute;n</a></li>
                		<li role="separator" class="divider"></li>
                		<li class="dropdown-header">Nav header</li>
                		<li><a href="#">Separated link</a></li>
                		<li><a href="#">One more separated link</a></li>
              		</ul>
            	</li>
            	<li><a href="#documental">Gesti&oacute;n Documental</a></li>
            	<li><a href="#contractual">Gesti&oacute;n Contractual</a></li>
            	<li><a href="#fisicos">Gesti&oacute;n de Recursos F&iacute;sicos</a></li>
            	<li><a href="#administrativa">&Aacute;rea Administrativa</a></li>
            	
          	</ul>
		</div><!--/.nav-collapse -->
	<!-- </div> -->
</nav>