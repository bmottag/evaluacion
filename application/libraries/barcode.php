<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//librerias requeridas
require_once('barcodegen/class/BCGFontFile.php');
require_once('barcodegen/class/BCGColor.php');
require_once('barcodegen/class/BCGDrawing.php');

class Barcode {
    
    private $pathImgages;
    private $pathFonts;
    
    public function __construct() {
        $this->pathImgages = base_dir('images/barcodes/');
        $this->pathFonts = base_dir('application/libraries/barcodegen/font/');
    }
    
    public function generar_barcode_ean8($codigo = '') {
        require_once('barcodegen/class/BCGean8.barcode.php');
        
        $rutaImagen = $this->pathImgages . $codigo . '.png';
        $imagen['dir'] = '';
        $imagen['url'] = '';
        
        // Definiendo colores y fuente
        $colorFront = new BCGColor(0, 0, 0);
        $colorBack = new BCGColor(255, 255, 255);
        $font = new BCGFontFile($this->pathFonts . 'Arial.ttf', 16);
        
        $code = new BCGean8(); //iniciar nuevo codigo
        // oagarzond - 2016-06-07 - Se comenta la linea 79 con el llamado de drawText en la libreria BCGean8 
        // para que no se dibuje el texto del codigo de barras
        $code->setScale(2); //escala o tamanio
        $code->setThickness(16); // modifica el alto
        $code->setForegroundColor($colorFront); // color de las barras
        $code->setBackgroundColor($colorBack); // color de fondo
        $code->setFont($font); // tipo de letra
        $code->parse($codigo); // codigo de 12 digitos

        $drawing = new BCGDrawing('', $colorBack);
        $drawing->setDPI(100);
        $drawing->setBarcode($code);

        /* guardar imagen en disco pero hay que comentar header */
        if (!file_exists($rutaImagen)) {
            $drawing->setFilename($rutaImagen);
            $drawing->draw(); // genera la imagen
            /* Vista de la imagen en el navegador pero hay que comentar setFileName */
            //header('Content-Type: image/png');
            $drawing->finish(BCGDrawing::IMG_FORMAT_PNG); //formato de generacion
        }
        
        if (file_exists($rutaImagen)) {
            $imagen['dir'] = $rutaImagen;
            $imagen['url'] = base_url('images/barcodes/' . $codigo . '.png');
        }
        return $imagen;
    }
    
    public function generar_barcode_ean13($codigo = '') {
        require_once('barcodegen/class/BCGean13.barcode.php');
        
        $rutaImagen = $this->pathImgages . $codigo . '.png';
        $imagen['dir'] = '';
        $imagen['url'] = '';
        
        // Definiendo colores y fuente
        $colorFront = new BCGColor(0, 0, 0);
        $colorBack = new BCGColor(255, 255, 255);
        $font = new BCGFontFile($this->pathFonts . 'Arial.ttf', 16);
        
        $code = new BCGean13(); //iniciar nuevo codigo
        // oagarzond - 2016-06-07 - Se comenta la linea 79 con el llamado de drawText en la libreria BCGean8 
        // para que no se dibuje el texto del codigo de barras
        $code->setScale(2); //escala o tamanio
        $code->setThickness(16); // modifica el alto
        $code->setForegroundColor($colorFront); // color de las barras
        $code->setBackgroundColor($colorBack); // color de fondo
        $code->setFont($font); // tipo de letra
        $code->parse($codigo); // codigo de 12 digitos

        $drawing = new BCGDrawing('', $colorBack);
        $drawing->setDPI(100);
        $drawing->setBarcode($code);

        /* guardar imagen en disco pero hay que comentar header */
        if (!file_exists($rutaImagen)) {
            $drawing->setFilename($rutaImagen);
            $drawing->draw(); // genera la imagen
            /* Vista de la imagen en el navegador pero hay que comentar setFileName */
            //header('Content-Type: image/png');
            $drawing->finish(BCGDrawing::IMG_FORMAT_PNG); //formato de generacion
        }
        
        if (file_exists($rutaImagen)) {
            $imagen['dir'] = $rutaImagen;
            $imagen['url'] = base_url('images/barcodes/' . $codigo . '.png');
        }
        return $imagen;
    }
}
//EOC