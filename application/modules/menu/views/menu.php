<!--	MENU   -->
<div class="container-fluid navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">

    </div>		
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <?php echo $mainMenu; ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php echo $rightMenu; ?>
        </ul>
    </div>

    <div class="row" id="colorbar">
        <div class="row col-md-offset-4 col-md-5 hidden-xs" id="color_container">
            <div id="color1"></div>
            <div id="color2"></div>
            <div id="color3"></div>
            <div id="color4"></div>
            <div id="color5"></div>
            <div id="color6"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>	
<!--	MENU   -->
<!-- Nombre del usuario y vinculacion -->
<?php if (isset($this->session->userdata['nom_usuario'])) { ?>
    <div class="container">	
        <div class="page-header text-right">
            <h6><?php echo strtoupper($this->session->userdata("nom_usuario") . ' ' . $this->session->userdata("ape_usuario")); ?>
                -
                <?php echo $this->session->userdata("tipov_usuario") == 1 ? 'PLANTA' : 'CONTRATISTA'; ?>
            </h6>
        </div>
    </div>
<?php } ?>