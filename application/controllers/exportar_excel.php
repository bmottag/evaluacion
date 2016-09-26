<?php 
ini_set('memory_limit', '512M');
//ini_set('memory_limit','-1');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para generar archivo Excel
 * @author oagarzond
 * @since 2016-06-08
 * @review 2016-06-08
 */
class Exportar_excel extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library("phpexcel/PHPExcel");
    }
    
    public function index() {
        
    }
    
    public function prueba() {
        $sheetId = 0;
        $this->phpexcel->createSheet(NULL, $sheetId);
        $this->phpexcel->setActiveSheetIndex($sheetId);
        $this->phpexcel->getActiveSheet()->setTitle("Excel de Prueba");
        $sheet = $this->phpexcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $styleArray = array('font' => array('bold' => true));
        $sheet->setCellValue('A3', 'Columna A3');
        $sheet->setCellValue('B3', 'Columna BB');
        $sheet->setCellValue('C3', 'Columna C3');
        $sheet->setCellValue('D3', 'Columna D3');
        $sheet->setCellValue('E3', 'Columna E3');
        $sheet->setCellValue('F3', 'Columna F3');
        $sheet->setCellValue('G3', 'Columna G3');
        $sheet->setCellValue('A4', 'Columna A4');
        $sheet->setCellValue('B4', 'Columna B4');
        $sheet->setCellValue('C4', 'Columna C4');
        $sheet->setCellValue('D4', 'Columna D4');
        $sheet->setCellValue('E4', 'Columna E4');
        $sheet->setCellValue('F4', 'Columna F4');
        $sheet->setCellValue('G4', 'Columna G4');
        $writer = new PHPExcel_Writer_Excel5($this->phpexcel);
        //header('Content-type: application/vnd.ms-excel');
        //$writer->save('php://output');
        //oagarzond - Para que se cargue uo diferente en IE se agrega un numero radicado al final del archivo - 2016-06-08
        $random = rand(100, 999);
        $writer->save(base_dir_tmp("prueba-" . $random . ".xls"));
        echo base_url_tmp("prueba-" . $random . ".xls");
    }
    
    public function asistencia() {
        $this->load->model('gh_asistencia/consultas_asistencias_model', 'cam');
        
        $postt = $this->input->post();
        if (!empty($postt) && count($postt) > 0) {
            foreach ($postt as $nombre_campo => $valor) {
                if (!is_array($postt[$nombre_campo])) {
                    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
                    eval($asignacion);
                }
            }
        }
        
        if (!empty($fecha_ini) && $fecha_ini != "-") {
            $arrParam["fechaDesde"] = $fecha_ini;
        }
        if (!empty($fecha_fin) && $fecha_fin != "-") {
            //$arrParam["fechaHasta"] = urldecode(formatear_fecha($valor));
            // Para que traiga el resultado real se debe sumar un dia mas a la fecha final
            $unixMark = strtotime("+1 day", strtotime(formatear_fecha($fecha_fin)));
            $arrParam["fechaHasta"] = date("d/m/Y", $unixMark);
        }
        if (!empty($cmbDespacho) && ($cmbDespacho != "-" && $cmbDespacho != "0")) {
            $arrParam["despacho"] = urldecode($cmbDespacho);
        }
        if (!empty($dependencia) && ($dependencia != "-" && $dependencia != "0")) {
            $arrParam["depen"] = urldecode($dependencia);
            unset($arrParam["despacho"]);
        }
        if (!empty($grupo) && ($grupo != "-" && $grupo != "0")) {
            $arrParam["grupo"] = urldecode($grupo);
            unset($arrParam["despacho"], $arrParam["depen"]);
        }
        if (!empty($txtDocu) && $txtDocu != "-") {
            $arrParam["txtDocu"] = urldecode($txtDocu);
        }
        if (!empty($txtNombres) && $txtNombres != "-") {
            $arrParam["txtNombres"] = strtoupper(urldecode($txtNombres));
        }
        if (!empty($txtApellidos) && $txtApellidos != "-") {
            $arrParam["txtApellidos"] = strtoupper(urldecode($txtApellidos));
        }

        //$arrParam["idPers"] = 452;
        //unset($arrParam["despacho"], $arrParam["depen"]);
        //pr($arrParam); exit;
        $datosAsis = $this->cam->buscar_asistencias($arrParam);
        //pr($datosAsis); exit;
        if (count($datosAsis) > 0) {
            $sheetId = 0;
            $this->phpexcel->createSheet(NULL, $sheetId);
            $this->phpexcel->setActiveSheetIndex($sheetId);
            $this->phpexcel->getProperties()->setTitle("Asistencia");
            $this->phpexcel->getProperties()->setCreator($this->session->userdata("nom_usuario"));
            $this->phpexcel->getProperties()->setLastModifiedBy($this->session->userdata("nom_usuario"));
            $sheet = $this->phpexcel->getActiveSheet();
            $sheet->mergeCells('A1:L1');
            $sheet->SetCellValue('A1', 'LISTADO DE ASISTENCIAS');
            $sheet->setCellValue('A2', 'No.');
            $sheet->setCellValue('B2', 'Cedula');
            $sheet->setCellValue('C2', 'Apellidos');
            $sheet->setCellValue('D2', 'Nombre(s)');
            $sheet->setCellValue('E2', 'Horario');
            $sheet->setCellValue('F2', 'Fecha');
            $sheet->setCellValue('G2', 'Hora entrada');
            $sheet->setCellValue('H2', 'Hora Salida');
            $sheet->setCellValue('I2', 'RE');
            $sheet->setCellValue('J2', 'RS');
            $sheet->setCellValue('K2', 'Permisos');
            $sheet->setCellValue('L2', 'TR');
            
            $i = 3; $tgracia = 10;
            foreach ($datosAsis AS $ia => $va) {
                $HE = $HS = $TR = 0;
                $va["RE"] = $va["RS"] = $va["TR"] = '';
                $va["permiso"] = '';
                $arrAnios = array(intval(date('Y')) - 1, intval(date('Y')), intval(date('Y')) + 1);
                $perfetti = calcular_viernes_perfetti($arrAnios);
                
                if (!empty($va["fecha"])) {
                    $tempFecha = explode("/", $va["fecha"]);
                    $tempHorarioE = explode(":", $va["hora_entrada"]);
                    $tempHorarioS = explode(":", $va["hora_salida"]);
                    $timestampE = mktime($tempHorarioE[0], $tempHorarioE[1] + $tgracia, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    $timestampS = mktime($tempHorarioS[0], $tempHorarioS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    if (in_array(formatear_fecha($va["fecha"]), $perfetti)) {
                       $va["fecha"] = '<div class="ui-jqgrid-light-blue">' .$va["fecha"] . '</div>';
                        $timestampE = mktime(7, (30 + $tgracia), 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                        $timestampS = mktime(15, 30, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                        if (!empty($va["HE"])) {
                            $tempHE = explode(':', $va["HE"]);
                            $timestampHE = mktime($tempHE[0], $tempHE[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                            if($timestampHE > $timestampE) {
                                $timestampE = mktime($tempHorarioE[0], $tempHorarioE[1] + $tgracia, 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                                $timestampS = mktime($tempHorarioS[0], $tempHorarioS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                            }
                        }
                    }
                }

                if (!empty($va["HE"])) {
                    $tempHE = explode(':', $va["HE"]);
                    $timestampHE = mktime($tempHE[0], $tempHE[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    $HE = ($timestampHE - $timestampE) / 60;
                    if ($HE > 0) {
                        $HE = $HE + $tgracia;
                       $va["RE"] = $HE;
                        $TR = $TR + $HE;
                    }
                } else {
                    $HE = 240;
                   $va["RE"] = $HE;
                    $TR = $TR + $HE;
                }
                
                if (!empty($va["HS"])) {
                    $tempHS = explode(':', $va["HS"]);
                    $timestampHS = mktime($tempHS[0], $tempHS[1], 0, $tempFecha[1], $tempFecha[0], $tempFecha[2]);
                    $HS = ($timestampS - $timestampHS) / 60;
                    if ($HS > 0) {
                       $va["RS"] = $HS;
                        $TR = $TR + $HS;
                    }
                } else {
                    //$datosAsis[$ia]["HS"] = '<input type="text" id="HS|' . $va["id"] . '|' . formatear_fecha($va["fecha"]) . 
                            '" placeholder="00:00" size="5" maxlength="5" onBlur="guardarHora(this.id)" />';
                    $HS = 240;
                   $va["RS"] = $HS;
                    $TR = $TR + $HS;
                }
                // Se revisa si tiene permiso para el mismo dia del registro
                if(!empty($va["id_sp"])) {
                    switch ($va["id_tipo_sp"]) {
                        case '1': // Fraccion
                            if(!empty($va["hora_ini_sp"]) && !empty($va["hora_fin_sp"])) {
                                $tempFechaIni = explode("/", $va["fecha_ini_sp"]);
                                $tempHIni = explode(':', $va["hora_ini_sp"]);
                                $timestampHIni = mktime($tempHIni[0], $tempHIni[1], 0, $tempFechaIni[1], $tempFechaIni[0], $tempFechaIni[2]);
                                $tempHFin = explode(':', $va["hora_fin_sp"]);
                                $timestampHFin = mktime($tempHFin[0], $tempHFin[1], 0, $tempFechaIni[1], $tempFechaIni[0], $tempFechaIni[2]);
                                $horas_permiso = ($timestampHFin - $timestampHIni) / 60;
                            }
                            break;
                        case '2': // Un dia
                            $horas_permiso = 480;
                            break;
                        case '3': // Dos dias
                            $horas_permiso = 480;
                            break;
                        case '4': // Tres dias
                            $horas_permiso = 480;
                            break;
                        default:
                            break;
                    }
                   $va["permiso"] = '';
                    $TR = $TR - $horas_permiso;
                }
                if($TR > 0) {
                   $va["TR"] = $TR;
                }
                
                
                $sheet->setCellValue('A' . $i, $i - 2);
                $sheet->setCellValue('B' . $i, $va["nume_docu"]);
                $sheet->setCellValue('C' . $i, $va["apellidos"]);
                $sheet->setCellValue('D' . $i, $va["nombres"]);
                $sheet->setCellValue('E' . $i, $va["hora_entrada"] . ' - ' . $va["hora_salida"]);
                $sheet->setCellValue('F' . $i, $va["fecha"]);
                $sheet->setCellValue('G' . $i, $va["HE"]);
                $sheet->setCellValue('H' . $i, $va["HS"]);
                $sheet->setCellValue('I' . $i, $va["RE"]);
                $sheet->setCellValue('J' . $i, $va["RS"]);
                $sheet->setCellValue('K' . $i, $va["permiso"]);
                $this->cellColor($sheet, 'L' . $i, 'FF0000');
                $sheet->setCellValue('L' . $i, $va["TR"]);
                $i++;
            }
            $writer = new PHPExcel_Writer_Excel5($this->phpexcel);
            $random = rand(100, 999);
            $writer->save(base_dir_tmp("reporte_asis-" . $random . ".xls"));
            echo base_url_tmp("reporte_asis-" . $random . ".xls");
        }
    }
    
    public function cellColor($sheet, $cells, $color) {
        $sheet->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => $color
            )
        ));
    }

}
// EOC