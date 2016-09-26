#!/bin/bash
# Tareas que se ejecutan de lunes a viernes - 2016-06-09
# Este archivo debe tener por lo menos permisos de ejecucion para todo el mundo - 775
# Se inserta en la tabla ASIS_FORM_CONTROL_ASISTENCIA en los dias habiles todas las personas que tenga codigo de barras
# wget 'http://192.168.1.200/daneweb/ghumana/gh_asistencia/insertarAsisDiario' -O /home1/home/dimpe/daneweb/ghumana/application/logs/insertarAsisDiario.html
# Se actualiza en la tabla ASIS_FORM_CONTROL_ASISTENCIA las horas de retardo de entrada y salida entre el rango de fechas
# wget 'http://192.168.1.200/daneweb/ghumana/gh_asistencia/actualizarRetardosDiario' -O /home1/home/dimpe/daneweb/ghumana/application/logs/actualizarRetardosDiario.html
wget 'http://danenet.dane.gov.co/ghumana/gh_asistencia/insertarAsisDiario' -O /var/www/html/aplicativos/ghumana/application/logs/insertarAsisDiario.html
wget 'http://danenet.dane.gov.co/ghumana/gh_asistencia/actualizarRetardosDiario' -O /var/www/html/aplicativos/ghumana/application/logs/actualizarRetardosDiario.html