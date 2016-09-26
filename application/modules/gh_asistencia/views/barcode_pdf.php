<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?=$titulo?></title>
    <style type="text/css">
        body {
         background-color: #fff;
         margin: 20px;
         font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
         font-size: 14px;
         color: #000;
        }
        table{
            text-align: center;
        }
    </style>
</head>
<body>
    <?php if(count($CB) > 0) {
        $total = count($CB);
    foreach ($CB as $kcb => $vcb) {
        if($kcb == 0) {
            echo '<table style="border: 2px #000 dotted;" cellpadding="6"><tr><td>' . $vcb['nombre'] . '<br /><div style="border: 2px #000 dotted; padding: 10px;"><img src="' . $vcb['imagenCB'] . '" /></div></td>';
        } else if(($kcb + 1) % 4 == 0 && ($kcb + 1) == $total) {
            echo '<td>' . $vcb['nombre'] . '<br /><div style="border: 2px #000 dotted; padding: 10px;"><img src="' . $vcb['imagenCB'] . '" /></div></td></tr></table>';
        } else if(($kcb + 1) % 4 == 0) {
            echo '<td>' . $vcb['nombre'] . '<br /><div style="border: 2px #000 dotted; padding: 10px;"><img src="' . $vcb['imagenCB'] . '" /></div></td></tr></table><table style="border: 2px #000 dotted;" cellpadding="6"><tr>';
        } else if(($kcb + 1) % 4 != 0) {
            echo '<td>' . $vcb['nombre'] . '<br /><div style="border: 2px #000 dotted; padding: 10px;"><img src="' . $vcb['imagenCB'] . '" /></div></td>';
        }
    } }?>
</body>
</html>