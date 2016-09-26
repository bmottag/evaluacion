<?php
$config = array(
    /**
     * Valido campos del formulario del registro de usuario
     */
    'formActosAdmin' => array(
        array(
            'field' => 'descripcion',
            'label' => '<strong>Descripción</strong>',
            'rules' => 'required'
        ),
        array(
            'field' => 'abogado',
            'label' => '<strong>Abogado encargado</strong>',
            'rules' => 'required'
        ),
        array(
            'field' => 'fecha_asignacion',
            'label' => '<strong>Fecha_asignación</strong>',
            'rules' => 'required'
        )
    )
);
?>