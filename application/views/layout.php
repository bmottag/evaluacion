<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="copyright" content="DANE" />
        <meta name="baseurl" content="<?=base_url()?>" />
        <title>Departamento Administrativo Nacional de Estad&iacute;stica (DANE)</title>
        <link href="<?php echo base_url_images("favicon.ico"); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link href="<?php echo base_url("/css/jquery-ui-1.8.18.custom.css"); ?>" rel="stylesheet"/>
        <link href="<?php echo base_url("/css/bootstrap.min.css"); ?>" rel="stylesheet"/>
        <link href="<?php echo base_url("/css/modificaBootstrap.css"); ?>" rel="stylesheet"/>
        <link href="<?php echo base_url("/css/jqgrid/trirand/ui.jqgrid-bootstrap.css"); ?>" rel="stylesheet"/>
        <link href="<?php echo base_url("/css/estilos.css"); ?>" rel="stylesheet"/>
        <script type="text/javascript" src="<?php echo base_url("/js/general/jquery-1.11.1.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("/js/general/jquery-ui.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("/js/general/jquery.validate.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("/js/general/danevalidator.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("/js/bootstrap/bootstrap.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("/js/general/bootbox.min.js"); ?>"></script>
        <!-- JQGRID -->
        <script type="text/ecmascript" src="<?php echo base_url("/js/jqgrid/trirand/i18n/grid.locale-es.js"); ?>"></script>
        <script type="text/ecmascript" src="<?php echo base_url("/js/jqgrid/trirand/jquery.jqGrid.min.js"); ?>"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <a href="javascript:void(0)" class="scrollup">Ir arriba</a>
        <?php
        //Carga el módulo que genera el menu de opciones.
        echo Modules::run("menu/menu/index");
        ?>
        <!-- Inicia Contenido -->
        <?php
        if (isset($view) && ($view != '')) {
            $this->load->view($view);
        }
        ?>
        <!-- Finaliza Contenido -->
        <?php $this->load->view("/template/footer"); ?>
    </body>
</html>