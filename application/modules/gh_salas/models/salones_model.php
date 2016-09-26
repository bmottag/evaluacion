<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class salones_model extends CI_Model 
{	
	/**
	 * Ingresa nueva solicitud de sala en la base de datos
	 * @author BMOTTAG
	 * @since 21/10/2013
	 * @review 19/10/2015
	 */		
	public function add_sala()
	{
		$user = $this->session->userdata("id");
		$salaId = $this->input->post('salaId');
		$fechaApartado = $this->input->post('fecha');
		$horaIni = $this->input->post('horaIni');
		$horaFin = $this->input->post('horaFin');
		$NroPersonas = $this->input->post('NroPersonas');
		$titulo = $this->input->post('titulo');
		$descripcion = $this->input->post('descripcion');
		$estado = 1;
		
	    $sql = "INSERT INTO GH_FORM_SOLICITUD_SALA
		(ID_SOLICITUD_SALA, FK_ID_USUARIO, FK_ID_SALA, FECHA_APARTADO, HORA_INICIO, HORA_FINAL, NRO_PERSONAS, TITULO_EVENTO, DESCRIPCION, FECHA_SOLICITUD, FK_ID_ESTADO) 
		VALUES (SEQ_FORM_SOLICITUD_SALA.Nextval, $user, $salaId, '$fechaApartado', '$horaIni', '$horaFin', $NroPersonas, '$titulo', '$descripcion', SYSDATE, 1 )";

	    $query = $this->db->query($sql);		

		if($query) return true;
		else return false;		
	}	
	
	/**
	 * Actualizar estado del permiso
	 * @review 20/10/2015
	 */
	public function update_estado_solicitud()
	{
		$this->load->model("fecha_hora");
		$fechaAct = $this->fecha_hora->fechaActualOracle('f');			
		
		$data = array(
			'FK_ID_ESTADO' => $this->input->post('estadoId'),
			'FECHA_MODIFICADO' => $fechaAct,
			'MODIFICADO_POR' => $this->session->userdata("id")
		);
		$this->db->where('ID_SOLICITUD_SALA', $this->input->post('idSolicitud'));
		$query = $this->db->update('GH_FORM_SOLICITUD_SALA', $data); 

		if($query)
			return true;
		else return false;
	}

	/**
	 * Bloqueear o desbloquear una sala
	 * @review 26/10/2015
	 */
	public function estado_sala()
	{
		$estado = $this->input->post('estado')==1?2:1;
		
		$data = array(
			'ESTADO' => $estado
		);
		$this->db->where('ID_SALA', $this->input->post('sala_Id'));
		$query = $this->db->update('GH_PARAM_SALAS', $data); 

		if($query)
			return true;
		else return false;
	}


	
	
	
}