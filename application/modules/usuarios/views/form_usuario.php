<div class="container">

    <!------<ul id="tabs" class="nav nav-tabs" data-tabs="tabs" style="display: none;">-->
    <?php $mostrarTabs = "";
    if (is_null($user["POLITICA"]) || $user["POLITICA"] == '' || $user["POLITICA"] != 1) {
        $mostrarTabs = 'style="display: none;"';
    } ?>
    

<!-------- Barra de progreso -------->
<div class="row" align="center">
	<div style="width:50%;" align="center">
            <div class="progress progress-striped active">
                    <div class="progress-bar <?php echo $colorProgreso; ?>" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $progreso; ?>%">
                            <span > <?php echo round($progreso); ?>% completado</span>
                    </div>
            </div>
	</div>
</div>		
<!-------- Barra de progreso -------->

    <div id="content">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs" <?php echo $mostrarTabs; ?> >
            <li class="<?php echo $tab1; ?>"><a href="#red" data-toggle="tab">Informaci&oacute;n B&aacute;sica</a></li>
            <li class="<?php echo $tab2; ?>"><a href="#green" data-toggle="tab">Informaci&oacute;n Personal</a></li>
            <li class="<?php echo $tab3; ?>"><a href="#yellow" data-toggle="tab">Foto de Perfil</a></li>
        </ul>
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane <?php echo $tab1; ?>" id="red">
                <?php $this->load->view("tab_general"); ?>
            </div>
            <div class="tab-pane <?php echo $tab2; ?>" id="green">
                <?php $this->load->view("tab_especifica"); ?>
            </div>
            <div class="tab-pane <?php echo $tab3; ?>" id="yellow">
                <?php $this->load->view("tab_imagen"); ?>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#tabs').tab();
        });
    </script>    
</div> <!-- container -->