<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class menu_model extends CI_Model {

    /**
     * Consulta lista de modulos dependiendo del tema y el usuario
     * @param idTema 
     * @since 28/07/2015
     */
    public function get_modulos($idTema) {
        $idUser = $this->session->userdata['id'];
        if ($idTema != 1) {
            $sql = "SELECT DISTINCT M.* FROM GH_ADMIN_RELACION_PERMISOS REL
                    INNER JOIN GH_ADMIN_PERMISOS PER ON PER.ID_PERMISO = REL.FK_ID_PERMISO 
                    INNER JOIN GH_ADMIN_MODULOS M ON M.ID_MODULOS = PER.FK_ID_MODULOS
                    WHERE PER.ESTADO = 1 AND PER.ESTADO = 1 AND M.FK_ID_TEMA = " . $idTema . " AND REL.FK_ID_USUARIO = " . $idUser . "
                    ORDER BY M.NOMBRE_MODULO";
        } else {
            $sql = "SELECT DISTINCT M.* FROM GH_ADMIN_MODULOS M
                    INNER JOIN GH_ADMIN_PERMISOS PER ON PER.FK_ID_MODULOS = M.ID_MODULOS 
                    WHERE PER.ESTADO = 1 AND M.FK_ID_TEMA = 1
                    ORDER BY M.NOMBRE_MODULO";
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }

    /**
     * Consulta menu para cada modulo
     * @param idModulo
     * @param idTema
     * @since 28/07/2015
     */
    public function get_menu($idModulo, $idTema) {
        $idUser = $this->session->userdata['id'];
        if ($idTema != 1) {
            $sql = "SELECT ME.ID_MENU, ME.NOMBRE_MENU, ME.ENLACE, ME.IMG FROM GH_ADMIN_RELACION_PERMISOS REL
                    INNER JOIN GH_ADMIN_PERMISOS PER ON PER.ID_PERMISO = REL.FK_ID_PERMISO 
                    INNER JOIN GH_ADMIN_MODULOS M ON M.ID_MODULOS = PER.FK_ID_MODULOS
                    INNER JOIN GH_ADMIN_MENU ME ON ME.FK_ID_PERMISOS = REL.FK_ID_PERMISO
                    WHERE REL.FK_ID_USUARIO = " . $idUser . " AND M.ID_MODULOS = " . $idModulo . "
                    ORDER BY PER.ID_PERMISO, ME.ORDEN";
        } else {
            $sql = "SELECT ME.ID_MENU, ME.NOMBRE_MENU, ME.ENLACE, ME.IMG FROM GH_ADMIN_MENU ME
                    INNER JOIN GH_ADMIN_PERMISOS P ON P.ID_PERMISO = ME.FK_ID_PERMISOS
                    INNER JOIN GH_ADMIN_MODULOS M ON M.ID_MODULOS = P.FK_ID_MODULOS
                    WHERE M.ID_MODULOS = " . $idModulo . "
                    ORDER BY P.ID_PERMISO, ME.ORDEN";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * Consulta tema dependiendo del usuario
     * @since 28/07/2015
     */
    public function get_tema() {
        $idUser = $this->session->userdata['id'];
        $sql = "SELECT DISTINCT T.* FROM GH_ADMIN_RELACION_PERMISOS REL
                INNER JOIN GH_ADMIN_PERMISOS PER ON PER.ID_PERMISO = REL.FK_ID_PERMISO 
                INNER JOIN GH_ADMIN_MODULOS M ON M.ID_MODULOS = PER.FK_ID_MODULOS
                INNER JOIN GH_ADMIN_TEMA T ON T.ID_TEMA = M.FK_ID_TEMA
                WHERE REL.FK_ID_USUARIO = " . $idUser . " AND PER.ESTADO = 1
                ORDER BY T.NOMBRE_TEMA";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * Adicionar/Editar MODULOS
     * @since 25/06/2015
     */
    public function modulos($idModulo) {
        $data = array(
            'NOMBRE_MODULO' => $this->input->post('modulo'),
            'FK_ID_TEMA' => $this->input->post('tema')
        );
        //revisar si es para adicionar o editar
        if ($idModulo == 'x') {
            $sql = 'SELECT MAX(ID_MODULOS) "MAX" FROM GH_ADMIN_MODULOS';
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $data['ID_MODULOS'] = $row->MAX + 1;
            }
            $query = $this->db->insert('GH_ADMIN_MODULOS', $data);
        } else {
            $this->db->where('ID_MODULOS', $idModulo);
            $query = $this->db->update('GH_ADMIN_MODULOS', $data);
        }
        if ($query)
            return true;
        else
            return false;
    }

    /**
     * Adicionar/Editar PERMISOS
     * @since 25/06/2015
     */
    public function permisos($idPermiso) {
        $data = array(
            'NOMBRE_PERMISO' => $this->input->post('permiso'),
            'FK_ID_MODULOS' => $this->input->post('modulo'),
            'DESCRIPCION' => $this->input->post('descripcion'),
            'ESTADO' => $this->input->post('estado'),
            'PERFIL' => $this->input->post('perfil'),
            'POR_DEFECTO' => $this->input->post('xdefecto'),
            'TIPO_USUARIO' => $this->input->post('tipo_usuario')
        );
        //revisar si es para adicionar o editar
        if ($idPermiso == 'x') {
            $sql = 'SELECT MAX(ID_PERMISO) "MAX" FROM GH_ADMIN_PERMISOS';
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $data['ID_PERMISO'] = $row->MAX + 1;
            }
            $query = $this->db->insert('GH_ADMIN_PERMISOS', $data);
        } else {
            $this->db->where('ID_PERMISO', $idPermiso);
            $query = $this->db->update('GH_ADMIN_PERMISOS', $data);
        }
        if ($query)
            return true;
        else
            return false;
    }

    /**
     * Adicionar/Editar ITEMS DEL MENU
     * @since 25/06/2015
     */
    public function menu($idMenu) {
        $data = array(
            'NOMBRE_MENU' => $this->input->post('men'),
            'FK_ID_PERMISOS' => $this->input->post('permiso'),
            'ENLACE' => $this->input->post('enlace'),
            'ORDEN' => $this->input->post('orden'),
            'IMG' => $this->input->post('imagen')
        );
        //revisar si es para adicionar o editar
        if ($idMenu == 'x') {
            $sql = 'SELECT MAX(ID_MENU) "MAX" FROM GH_ADMIN_MENU';
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $data['ID_MENU'] = $row->MAX + 1;
            }
            $query = $this->db->insert('GH_ADMIN_MENU', $data);
        } else {
            $this->db->where('ID_MENU', $idMenu);
            $query = $this->db->update('GH_ADMIN_MENU', $data);
        }
        if ($query)
            return true;
        else
            return false;
    }

    /**
     * @author BMOTTAG
     * @since4/8/2015
     * Consulta permisos de un usuario especifico
     */
    public function get_relacion_permisos($idUser, $idPermiso) {
        $this->db->where('FK_ID_USUARIO', $idUser);
        $this->db->where('FK_ID_PERMISO', $idPermiso);
        $query = $this->db->get('GH_ADMIN_RELACION_PERMISOS');

        if ($query->num_rows() == 1) {
            return TRUE;
        } else
            return FALSE;
    }

    /**
     * Actualizar permisos del usuario
     */
    public function update_permisos($idModulo = 'x') {
        $idUser = $this->input->post('idUser');
        if ($idModulo == 'x') {
            //Elimino permisos anteriores
            $this->db->delete('GH_ADMIN_RELACION_PERMISOS', array('FK_ID_USUARIO' => $this->input->post('idUser')));
        } else {
            //Elimino permisos solo para un modulo especifico
            $sql = "SELECT R.*
                    FROM GH_ADMIN_RELACION_PERMISOS R
                    INNER JOIN GH_ADMIN_PERMISOS P ON P.ID_PERMISO = R.FK_ID_PERMISO
                    WHERE R.FK_ID_USUARIO = $idUser AND P.FK_ID_MODULOS = $idModulo";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $i = 0;


                /* foreach($query->result() as $row){
                  $deps[$i]["id_dependencia"] = $row->COD_DEPENDENCIA;
                  $deps[$i]["nom_dependencia"] = $row->DEPENDENCIA;
                  $i++;
                  } */
                foreach ($query->result_array() as $item) {
                    $this->db->delete('GH_ADMIN_RELACION_PERMISOS', array('FK_ID_USUARIO' => $item['FK_ID_USUARIO'],
                        'FK_ID_PERMISO' => $item['FK_ID_PERMISO']));
                }
            }
        }
        //ingreso los nuevos permisos
        $query = 1;
        if ($permisos = $this->input->post('perfil')) {
            $tot = count($permisos);
            for ($i = 0; $i < $tot; $i++) {
                $data = array(
                    'FK_ID_USUARIO' => $idUser,
                    'FK_ID_PERMISO' => $permisos[$i]
                );
                $query = $this->db->insert('GH_ADMIN_RELACION_PERMISOS', $data);
            }
        }
        if ($query) {
            return true;
        } else
            return false;
    }
    
    public function consultar_enlaces($arrDatos) {
        $cond = "";
        $data = array();
        if (array_key_exists("idPermiso", $arrDatos)) {
            $cond .= " AND ARP.FK_ID_PERMISOS = '" . $arrDatos ["idPers"] . "'";
        }
        if (array_key_exists("enlace", $arrDatos)) {
            $cond .= " AND AM.ENLACE = '" . $arrDatos['enlace'] . "'";
        }
        $sql = "SELECT AM.* 
            FROM GH_ADMIN_MENU AM 
            WHERE AM.ID_MENU IS NOT NULL" . $cond .
            " ORDER BY AM.ID_MENU ASC";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result('array') as $row) {
                $data[] = $row;
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }
    
    public function consultar_permisos_enlace($arrDatos) {
        $cond = "";
        $data = array();
        if (array_key_exists("idPers", $arrDatos)) {
            $cond .= " AND ARP.FK_ID_USUARIO = '" . $arrDatos ["idPers"] . "'";
        }
        if (array_key_exists("enlace", $arrDatos)) {
            $cond .= " AND AM.ENLACE LIKE '" . $arrDatos['enlace'] . "%'";
        }
        $sql = "SELECT ARP.FK_ID_USUARIO, AP.ID_PERMISO, AP.* 
            FROM GH_ADMIN_MENU AM 
            LEFT JOIN GH_ADMIN_PERMISOS AP ON (AP.ID_PERMISO = AM.FK_ID_PERMISOS) 
            LEFT JOIN GH_ADMIN_RELACION_PERMISOS ARP ON (ARP.FK_ID_PERMISO = AM.FK_ID_PERMISOS) 
            WHERE AM.ID_MENU IS NOT NULL" . $cond .
            " ORDER BY AM.ID_MENU ASC";
        //pr($sql); exit;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result('array') as $row) {
                $data[] = $row;
            }
        }
        //pr($data); exit;
        $this->db->close();
        return $data;
    }
    
		/**
		 * Actualizar table dependencia con el jefe
		 * @since 20/06/2016
		 */
		public function add_jefe()
		{
				$idUser = $this->input->post('hddIdentificador');
				$despacho = $this->input->post('cmbDespacho');
				$dependencia = $this->input->post('dependencia');
				$grupo = $this->input->post('grupo');
                                $cargo = $this->input->post('cargo');
                                $idDependencia = "";
                                
                                if($grupo != ""){
                                    $idDependencia = $grupo;
                                }elseif($dependencia != ""){
                                    $idDependencia = $dependencia;
                                }else{
                                    $idDependencia = $despacho;
                                }
		
                                $sql = "UPDATE GH_PARAM_DEPENDENCIA
                                        SET FK_ID_USUARIO=$idUser, CARGO=$cargo
                                        WHERE CODIGO_DEPENDENCIA=$idDependencia";				


				$query = $this->db->query($sql);		

				if($query){ return true; }
				else{ return false; }		
		}
    
}
?>