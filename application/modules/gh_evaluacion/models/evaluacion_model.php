<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class evaluacion_model extends CI_Model {

    /**
     * Adicionar/Editar OFICINA
     * @since 01/06/2016
     */
    public function add_oficina() {
        $idOficina = $this->input->post('hddIdentificador');
        $idDependencia = $this->input->post('dependencia');

        //verificar si la dependencia es una territorial o es de nivel central para en la calificacion aplicar los procentajes 
        $sql = "SELECT ANTECESOR FROM GH_PARAM_DEPENDENCIA WHERE CODIGO_DEPENDENCIA='$idDependencia'";
        $query = $this->db->query($sql);
        $row = $query->row();
        $antecesor = $row->ANTECESOR;
        $tipoGerente = 2; //nivel central
        if ($antecesor == 4) {
            $tipoGerente = 1; //direcciones territoriales
        }

        $data = array(
            'FK_ID_DEPENDENCIA' => $idDependencia,
            'EVALUADOR' => $this->input->post('evaluador'),
            'ESTADO' => $this->input->post('estado'),
            'TIPO_GERENTE_PUBLICO' => $tipoGerente
        );
        //revisar si es para adicionar o editar
        if ($idOficina == '') {
            $sql = 'SELECT MAX(ID_OFICINA) "MAX" FROM EVAL_PARAM_OFICINA';
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $data['ID_OFICINA'] = $row->MAX + 1;
            }
            $query = $this->db->insert('EVAL_PARAM_OFICINA', $data);
        } else {
            $this->db->where('ID_OFICINA', $idOficina);
            $query = $this->db->update('EVAL_PARAM_OFICINA', $data);
        }
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar MACROPROCESOS
     * @since 01/06/2016
     */
    public function add_macroproceso() {
        $idMacroproceso = $this->input->post('hddIdentificador');

        $data = array(
            'FK_ID_AREA' => $this->input->post('area'),
            'MACROPROCESO' => $this->input->post('macroproceso'),
            'FK_ID_USUARIO' => $this->input->post('jefe'),
            'ESTADO' => $this->input->post('estado')
        );
        //revisar si es para adicionar o editar
        if ($idMacroproceso == '') {
            $sql = 'SELECT MAX(ID_MACROPROCESO) "MAX" FROM EVAL_PARAM_MACROPROCESO';
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $data['ID_MACROPROCESO'] = $row->MAX + 1;
            }
            $query = $this->db->insert('EVAL_PARAM_MACROPROCESO', $data);
        } else {
            $this->db->where('ID_MACROPROCESO', $idMacroproceso);
            $query = $this->db->update('EVAL_PARAM_MACROPROCESO', $data);
        }
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar MACROPROCESOS
     * @since 01/06/2016
     */
    public function add_pilar() {
        $idPilar = $this->input->post('hddIdentificador');

        $data = array(
            'PILAR' => $this->input->post('pilar'),
            'DEFINICION_PILAR' => $this->input->post('definicion'),
            'ESTADO' => $this->input->post('estado')
        );
        //revisar si es para adicionar o editar
        if ($idPilar == '') {
            $sql = 'SELECT MAX(ID_PILAR) "MAX" FROM EVAL_PARAM_PILAR';
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $data['ID_PILAR'] = $row->MAX + 1;
            }
            $query = $this->db->insert('EVAL_PARAM_PILAR', $data);
        } else {
            $this->db->where('ID_PILAR', $idPilar);
            $query = $this->db->update('EVAL_PARAM_PILAR', $data);
        }
        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar/Editar MACROPROCESOS para una OFICINA
     * @since 01/06/2016
     */
    public function add_macro($idAcuerdo, $pesoTotal) {
        $idOficina = $this->input->post('hddIdOficina');
        $macroproceso = $this->input->post('macroproceso');
        $peso = $this->input->post('peso');
        $vigencia = date('Y');

        //revisar existe el acuerdo 
        if ($idAcuerdo == '') {
            $sql = "INSERT INTO EVAL_ACUERDO
								(ID_ACUERDO, FK_ID_OFICINA, FECHA_ACUERDO, VIGENCIA, PESO_TOTAL) 
								VALUES (SEQ_FORM_ACUERDO.Nextval, $idOficina, SYSDATE, '$vigencia', $pesoTotal)";

            //ADICIONO ACUERDO
            $query = $this->db->query($sql);

            if ($query) 
			{
                $sql = 'SELECT MAX(ID_ACUERDO) "MAX" FROM EVAL_ACUERDO';
                $query = $this->db->query($sql);
                $row = $query->row();
                $idAcuerdo = $row->MAX;
				
				//INICIO --- guardar datos en la tabla historico
				$arrParam = array(
					"idMensaje" => 1,  //ID = 1 -> se crea el acuerdo
					"mensaje" => "Se creó el acuerdo",
					"idAcuerdo" => $idAcuerdo
				);

				$this->evaluacion_model->add_historico($arrParam);
				//FIN --- guardar datos en la tabla historico
				
            } else {
                return false;
            }
        } else {
            $sql = "UPDATE EVAL_ACUERDO
								SET PESO_TOTAL=$pesoTotal
								WHERE ID_ACUERDO=$idAcuerdo";

            //ACTUALIZO PESO DEL ACUERDO
            $query = $this->db->query($sql);
        }

        //revisar si se guardo el ACUERDO
        if ($query) {
            $sql = "INSERT INTO EVAL_ASIGNAR_MACRO
								(ID_ASIGNAR_MACRO, FK_ID_MACROPROCESO, FK_ID_ACUERDO, PESO_ASIGNADO, FECHA, PESO_PROGRAMADO, ESTADO) 
								VALUES (SEQ_FORM_MACRO.Nextval, $macroproceso, $idAcuerdo, $peso, SYSDATE, 0, 1)";

            $query = $this->db->query($sql);

            if ($query) {
                $sql = 'SELECT MAX(ID_ASIGNAR_MACRO) "MAX" FROM EVAL_ASIGNAR_MACRO';
                $query = $this->db->query($sql);
                $row = $query->row();
                $idAsignarMacro = $row->MAX;
				
                return $idAsignarMacro;//devuelvo el id registrado para guardarlo en el historico
            } else {
                return false;
            }
        }
    }

    /**
     * Adicionar Compromiso para el macroprcoso
     * @since 18/06/2016
     */
    public function add_compromiso() {
        $idMacroproceso = $this->input->post('hddIdMacro');
        $pesoProgramado = $this->input->post('hddPesoProgramado');
        $idPilar = $this->input->post('pilar');
        $resultado = $this->input->post('resultado');
        $compromisos = $this->input->post('compromisos');
        $indicador = $this->input->post('indicador');
        $peso = $this->input->post('peso');
        $abril = $this->input->post('abril');
        $agosto = $this->input->post('agosto');
        $diciembre = $this->input->post('diciembre');

        $pesoTotal = $peso + $pesoProgramado; //peso total programado para el maroproceso
        //actualizar peso programado para el mracroproceso
        $sql = "UPDATE EVAL_ASIGNAR_MACRO
						SET PESO_PROGRAMADO=$pesoTotal
						WHERE ID_ASIGNAR_MACRO=$idMacroproceso";

        $query = $this->db->query($sql);

        if ($query) {
            //ingresar nuevo compromiso
            $sql = "INSERT INTO EVAL_ASIGNAR_PILAR
								(ID_ASIGNAR_PILAR, FK_ID_PILAR, FK_ID_ASIGNAR_MACRO, PESO_PILAR, COMPROMISO, RESULTADO_ESPERADO, INDICADOR, ESPERADO_ABRIL, ESPERADO_AGOSTO, ESPERADO_DICIEMBRE, ESTADO, FECHA_PILAR) 
								VALUES (SEQ_FORM_CONCERTACION.Nextval, $idPilar, $idMacroproceso, $peso, '$compromisos', '$resultado', '$indicador', $abril, $agosto, $diciembre, 1, SYSDATE)";

            $query = $this->db->query($sql);

            if ($query) {
                $sql = 'SELECT MAX(ID_ASIGNAR_PILAR) "MAX" FROM EVAL_ASIGNAR_PILAR';
                $query = $this->db->query($sql);
                $row = $query->row();
                $idAsignarPilar = $row->MAX;
				
                return $idAsignarPilar;//devuelvo el id registrado para guardarlo en el historico
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Actualizar peso total asignado en la tabla acuerdo
     * @since 19/06/2016
     */
    public function update_acuerdo($idAcuerdo, $pesoNuevo) {
        $data = array(
            'PESO_TOTAL' => $pesoNuevo
        );

        $this->db->where('ID_ACUERDO', $idAcuerdo);
        $query = $this->db->update('EVAL_ACUERDO', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Actualizar peso total asignado en la tabla asignar macro
     * @since 13/07/2016
     */
    public function update_asignar_macro($idAsignarMacro, $pesoNuevo) {
        $data = array(
            'PESO_PROGRAMADO' => $pesoNuevo
        );

        $this->db->where('ID_ASIGNAR_MACRO', $idAsignarMacro);
        $query = $this->db->update('EVAL_ASIGNAR_MACRO', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar seguimiento 
     * @since 23/06/2016
     */
    public function add_seguimiento() {

        $periodo = $this->input->post('hddPeriodo'); //periodo al que se esta haciendo seguimiento
        $idAsginarPilar = $this->input->post('hddIdAsignarPilar');
        $peso = $this->input->post('peso');
        $avance = $this->input->post('avance');

        if ($periodo == "ABRIL") {
            $actualizacion = " SET SEGUIMIENTO_ABRIL=$peso, AVANCE_ABRIL='$avance', FECHA_SEG_ABRIL = SYSDATE ";
        } elseif ($periodo == "AGOSTO") {
            $actualizacion = " SET SEGUIMIENTO_AGOSTO=$peso, AVANCE_AGOSTO='$avance', FECHA_SEG_AGOSTO = SYSDATE ";
        } elseif ($periodo == "DICIEMBRE") {
            $actualizacion = " SET SEGUIMIENTO_DICIEMBRE =$peso, AVANCE_DICIEMBRE='$avance', FECHA_SEG_DICIEMBRE = SYSDATE ";
        } else {
            return false;
        }

        //actualizar seguimiento
        $sql = "UPDATE EVAL_ASIGNAR_PILAR ";
        $sql.= $actualizacion;
        $sql.= " WHERE ID_ASIGNAR_PILAR=$idAsginarPilar";

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adicionar macroproceso para PLANTILLA
     * @since 8/07/2016
     */
    public function add_macro_plantilla() {
        $data = array(
            'TIPO_GERENTE_PUBLICO' => $this->input->post('hddIdParam'),
            'FK_ID_MACROPROCESO' => $this->input->post('macroproceso'),
            'PESO_SUGERIDO' => $this->input->post('peso')
        );

        $sql = 'SELECT MAX(ID_PLANTILLA) "MAX" FROM EVAL_PARAM_PLANTILLA';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data['ID_PLANTILLA'] = $row->MAX + 1;
        }
        $query = $this->db->insert('EVAL_PARAM_PLANTILLA', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Crea los acuerdos y los macroporcesos con sus pesos de acuerdo a la plantilla
     * @since 01/06/2016
     */
    public function add_datos_plantilla($info) {
        $vigencia = date('Y');
        if ($info['idTipoGerente'] == 1) {
            $pesoTotal = 200; //peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
        } else {
            $pesoTotal = 100; //peso maximo que se puede programar ----HACER TABLA PARAMETRICA PARA ESTE DATO
        }

        foreach ($info['oficinas'] as $datos):
            $idOficina = $datos['ID_OFICINA'];
            $sql = "INSERT INTO EVAL_ACUERDO (ID_ACUERDO, FK_ID_OFICINA, FECHA_ACUERDO, VIGENCIA, PESO_TOTAL)";
            $sql.= " VALUES (SEQ_FORM_ACUERDO.Nextval, $idOficina, SYSDATE, '$vigencia', $pesoTotal)";

            //ADICIONO ACUERDO
            $query = $this->db->query($sql);

            if ($query) {
                $sql = 'SELECT MAX(ID_ACUERDO) "MAX" FROM EVAL_ACUERDO';
                $query = $this->db->query($sql);
                $row = $query->row();
                $idAcuerdo = $row->MAX;
				
				//INICIO --- guardar datos en la tabla historico
				$arrParam = array(
					"idMensaje" => 1,  //ID = 1 -> se crea el acuerdo
					"mensaje" => "Se creó el acuerdo desde la plantilla",
					"idAcuerdo" => $idAcuerdo
				);

				$this->evaluacion_model->add_historico($arrParam);
				//FIN --- guardar datos en la tabla historico

                foreach ($info['macroSugerido'] as $datos):
                    $macroproceso = $datos->FK_ID_MACROPROCESO;
                    $peso = $datos->PESO_SUGERIDO;

                    $sql = "INSERT INTO EVAL_ASIGNAR_MACRO";
                    $sql.= " (ID_ASIGNAR_MACRO, FK_ID_MACROPROCESO, FK_ID_ACUERDO, PESO_ASIGNADO, FECHA, PESO_PROGRAMADO, ESTADO)";
                    $sql.= " VALUES (SEQ_FORM_MACRO.Nextval, $macroproceso, $idAcuerdo, $peso, SYSDATE, 0, 1)";

                    //ADICIONO MACROPROCESO
                    $query = $this->db->query($sql);
					if($query){//guardo historial de la nueva asingacion del macroproceso
						//INICIO --- guardar datos en la tabla historico
						$sql = 'SELECT MAX(ID_ASIGNAR_MACRO) "MAX" FROM EVAL_ASIGNAR_MACRO';
						$query = $this->db->query($sql);
						$row = $query->row();
						$idAsignarMacro = $row->MAX;
						
						$arrParam = array(
							"idMensaje" => 2,  //ID = 2 -> se asigna macroproceso
							"mensaje" => "Se asignó macroproceso desde la plantilla",
							"idAcuerdo" => $idAcuerdo,
							"idAsignarMacro" => $idAsignarMacro
						);
				
						$this->evaluacion_model->add_historico($arrParam);
						//FIN --- guardar datos en la tabla historico
					}
                endforeach;
            }
        endforeach;
        return true;
    }

    /**
     * Actualizar los datos de la aprobacion del seguimiento de un periodo
     * @since 17/07/2016
     */
    public function update_aprobacion() {
        $periodo = $this->input->post('hddPeriodo'); //periodo al que se esta haciendo seguimiento
        $idAsginarPilar = $this->input->post('hddIdAsignarPilar');
        $aprobar = $this->input->post('aprobar');
        $peso = $aprobar == 1 ? '' : $this->input->post('peso');
        $observacion = $aprobar == 1 ? '' : $this->input->post('observacion');

        if ($periodo == "ABRIL") {
            $actualizacion = " SET APROBAR_ABRIL=$aprobar, SEG_EVALUADOR_ABRIL='$peso', OBS_EVALUADOR_ABRIL='$observacion', FECHA_APROBAR_ABRIL = SYSDATE ";
        } elseif ($periodo == "AGOSTO") {
            $actualizacion = " SET APROBAR_AGOSTO=$aprobar, SEG_EVALUADOR_AGOSTO='$peso', OBS_EVALUADOR_AGOSTO='$observacion', FECHA_APROBAR_AGOSTO = SYSDATE ";
        } elseif ($periodo == "DICIEMBRE") {
            $actualizacion = " SET APROBAR_DICIEMBRE =$aprobar, SEG_EVALUADOR_DICIEMBRE='$peso', OBS_EVALUADOR_DICIEMBRE='$observacion', FECHA_APROBAR_DICIEMBRE = SYSDATE ";
        } else {
            return false;
        }

        //actualizar
        $sql = "UPDATE EVAL_ASIGNAR_PILAR ";
        $sql.= $actualizacion;
        $sql.= " WHERE ID_ASIGNAR_PILAR=$idAsginarPilar";

        $query = $this->db->query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Ingresar datos en la base de datos
     */
    public function guardar_compromisos($idAcuerdo) {
        $this->db->delete('EVAL_COMPROMISO_MEJORA', array('FK_ID_ACUERDO' => $idAcuerdo)); //borrar datos anteriores

        $num = $this->db->count_all('EVAL_PARAM_COMPROMISO'); //numero de registros de la lista innovacion

        for ($i = 1; $i <= $num; $i++) {
            if ($this->input->post('compromiso' . $i)) {
                $data = array(
                    'FK_ID_ACUERDO' => $idAcuerdo,
                    'FK_ID_COMPROMISO' => $i,
                    'NECESIDAD_MEJORA' => $this->input->post('compromiso' . $i)
                    
                );
                //Inserto estado de la solicitud
                $query = $this->db->insert('EVAL_COMPROMISO_MEJORA', $data);
            }
        }
		
		//Actualizo las observaciones en la tabla EVAL_ACUERDO
        $data = array(
            'OBSERVACIONES' => $this->input->post('observacion')
        );
        $this->db->where('ID_ACUERDO', $idAcuerdo);
        $query = $this->db->update('EVAL_ACUERDO', $data);		
		
		
		
        if ($query) {
            return true;
        } else
            return false;
    }

    /**
     * Actualizar calificacion en la tabla asignar pilar
     * @since 22/07/2016
     */
    public function update_asignar_pilar($arrDatos) {
        $data = array(
            'CALIFICACION' => $arrDatos['calificacion']
        );

        $this->db->where('ID_ASIGNAR_PILAR', $arrDatos['idAsignarPilar']);
        $query = $this->db->update('EVAL_ASIGNAR_PILAR', $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Eliminar REGISTRO
     * @since 09/06/2016
     */
    public function eliminarRegistro($arrDatos) {
        $query = $this->db->delete($arrDatos ["tabla"], array($arrDatos ["llavePrimaria"] => $arrDatos ["id"]));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
	
    /**
     * Actualizar el campo de una tabla
     * @since 11/09/2016
     */
    public function updateRegistro($arrDatos) {
        $data = array(
            $arrDatos ["campo"] => $arrDatos ["valor"]
        );

        $this->db->where($arrDatos ["llavePrimaria"], $arrDatos ["id"]);
        $query = $this->db->update($arrDatos ["tabla"], $data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
	
    /**
     * Adicionar cambios del acuerdo en tabla historio
	 * Lista de mensajes:
	 * 1 -> se crea el acuerdo
	 * 2 -> se asigna macroproceso
	 * 3 -> se elimina macroprocesos
	 * 4 -> se asigna compromisos
	 * 5 -> se elimina compromisos
	 * 6 -> se hace el seguimiento
	 * 7 -> se hace aprobacion
	 * 8 -> se guardan los compromisos adicionales
     * @since 12/09/2016 
     */
    public function add_historico($arrDatos) {
		$idUser = $this->session->userdata("id");
		
		$sql = 'SELECT MAX(ID_HISTORICO) "MAX" FROM EVAL_HISTORICO';
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$idHistorico = $row->MAX + 1;
		}
		
		$idMensaje = $arrDatos["idMensaje"];
		$mensaje = $arrDatos["mensaje"];
		$idAcuerdo = $arrDatos["idAcuerdo"];
		
		$sql = "INSERT INTO EVAL_HISTORICO";
		$sql .=	" (ID_HISTORICO, FECHA, FK_ID_USUARIO, ID_MENSAJE, MENSAJE, FK_ID_ACUERDO)";
		$sql .=	" VALUES ($idHistorico, SYSDATE, $idUser, $idMensaje, '$mensaje', $idAcuerdo)";

		$query = $this->db->query($sql);
		
        if (array_key_exists("idAsignarMacro", $arrDatos)) {//actializo el historico con el ID_ASIGNAR_MACRO

            $arrParam = array(
                "tabla" => "EVAL_HISTORICO",
                "llavePrimaria" => "ID_HISTORICO",
                "id" => $idHistorico,
				"campo" => "FK_ID_ASIGNAR_MACRO",
				"valor" => $arrDatos["idAsignarMacro"]
            );
            $this->evaluacion_model->updateRegistro($arrParam);

        }
        if (array_key_exists("idAsignarPilar", $arrDatos)) {//actializo el historico con el ID_ASIGNAR_MACRO
            
            $arrParam = array(
                "tabla" => "EVAL_HISTORICO",
                "llavePrimaria" => "ID_HISTORICO",
                "id" => $idHistorico,
				"campo" => "FK_ID_ASIGNAR_PILAR",
				"valor" => $arrDatos["idAsignarPilar"]
            );
            $this->evaluacion_model->updateRegistro($arrParam);
			
        }

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

}