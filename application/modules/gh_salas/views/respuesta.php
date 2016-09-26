<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="list-group-item-heading">
                <?php echo $titulo; ?>
            </h4>
        </div>
    </div>
	<div class="row" align="center">
		<div style="width:50%;" align="center">
			<div class="alert <?php echo $clase;?>"> <span class="glyphicon glyphicon-ok">&nbsp;</span>
				<?php echo $text; ?>
			</div>
			<?php 
			if(isset($boton))
				echo '<a class="btn btn-primary" href="' . site_url(). $boton .'">Regresar</a>';
			?>			
		</div>
	</div>	
</div>