<html>
<head>
	<style>
		body{
			font-family: verdana, sans-serif;
  			font-size: 12px;
  			color: #000000;
  			font-style: normal;
  			font-weight: normal;
  			font-variant: normal;
  			text-align: left;
  			letter-spacing: 0px;
  			line-height: 20px;
		}
	</style>
</head>
<body>
	<p>Bogot&aacute; D.C. <?php echo date("l jS \of F Y"); ?></p>
	<p>Señor(a):<br/>
	   <?php echo $nom_usuario." ".$ape_usuario; ?><br/>
	   Departamento Administrativo Nacional de Estad&iacute;stica (DANE)<br/>
	   Tel: <?php echo $tel_usuario; ?> Ext: <?php echo $ext_usuario; ?><br/>
	</p>
	<p>El Sistema de Gesti&oacute;n Humana ha generado el certificado de: <b><?php echo $nom_certificado; ?></b> solicitado por usted.<p>
	<p>Por favor ac&eacute;rquese al &aacute;rea de Gesti&oacute;n Humana para reclamarlo.</p>
	<p>Su n&uacute;mero de solicitud de certificado es: <b><?php echo $id_certificado; ?></b></p>
	<p>Gracias.</p>	
</body>
</html>