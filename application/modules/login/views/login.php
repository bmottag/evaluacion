<script type="text/javascript" src="<?php echo base_url("js/login/login.js"); ?>"></script>

<div class="modal fade" id="myModal" role="dialog"></div>
<div class="container" style="padding-top: 50px;">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">INGRESO</h3>Usuario&nbsp;y&nbsp;Contrase&ntilde;a&nbsp;de&nbsp;RED
                </div>
                <div class="panel-body">
                    <form class="form-signin" method="post" action="<?php echo site_url("/login/actualizar"); ?>">
                        <label for="inputLogin" >Usuario</label>
                        <input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="Usuario" required autofocus />
                        <br/>
                        <label for="inputPassword" >Contrase&ntilde;a</label>
                        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Contrase&ntilde;a" required />
                        <br/>
                        <button type="submit" id="btnIngresar" name="btnIngresar" class="btn btn-primary btn-block">Ingresar</button>
                    </form>
                    <br/>
                    <p align="center">
                        <a href="<?php echo site_url("/login/usuario"); ?>">Crear Usuario</a><br/>
                        <!--<a href="<?php // echo site_url("/login/recordatorio");  ?>">&iquest; Olvid&oacute; su contrase&ntilde;a ?</a>-->
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="jumbotron">
                <h1>&iexcl; Bienvenido !</h1>
                <p style="text-align: justify;">Has ingresado al aplicativo de relacionamiento con los colaboradores del DANE. Aquí podrás gestionar, consultar y actualizar con agilidad tu información y solicitudes de servicios.</p>
                <p style="text-align: justify;">Para facilitar tu acceso hemos dispuesto el siguiente enlace de ayuda donde podrás consultar el paso a paso para ingresar.</p>
                <p style="text-align: center;"><img src="<?=base_url_images('boton-como_ingresar-CRM.gif')?>" class="infoCRM" id="infografiaCRM" height="125" width="125" /></p>
                <p style="text-align: center; font-size: small;">Si tienes inquietudes o sugerencias por favor escríbenos al correo electrónico <a href="mailto:dazuletar@dane.gov.co" title="">dazuletar@dane.gov.co</a></p>
            </div>
        </div>
    </div>
</div>