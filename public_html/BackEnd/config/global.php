<?php
/*
Proyecto 	: Sistema web - Backend 
Fecha 		: 2023-04-02
Autor 		: Johnny Reque
Proposito	: Variables Globales
*/

date_default_timezone_set('America/Lima');

// Rutas
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
define('CONTROLADOR_PATH', ROOT_PATH.'controlador/');
define('MODELO_PATH', ROOT_PATH.'modelo/');
define('VISTA_PATH', ROOT_PATH.'vista/');
define('DEF_PATH_ADMIN','../config/lib_include_admin.php');

// Constantes
define("TITULO_PANEL", "SISTEMA ACADEMIA TKD");
define("SUBTITULO_PANEL", "Acceso de Usuarios");
define("COPYRIGHT_AUTOR", "Taekwon-Do");
define("COPYRIGHT_WEB", "http://www.jreque.com");
define("COPYRIGHT", "2023");
define("VERSION", "1.0");
define("SOPORTE_AUTOR", "Johnny Reque");
define("SOPORTE_EMAIL", "johnnyreque@gmail.com");
define("SOPORTE_MOVIL", "(+51) 977137699");
define("URL_WEB", "http://www.jmtalentgroup.com");
define("DEF_URL_LOGIN", "login_admin.php");
define("DEF_URL_LOGIN_INTRANET", "login_intranet.php");
define("TITULO_INTRANET", "INTRANET ACADEMIA TKD");
define("DEF_URL_LOGIN_SUBTITULO", "AFILIADO A LA FEDERACIÓN DEPORTIVA PERUANA DE TAEKWONDO");											  

// Textos de Mantenimiento
define('DEF_MSG_FORM_NUEVO', 'NUEVO');
define('DEF_MSG_FORM_EDICION', 'EDICIÓN');
define('DEF_MSG_FORM_LISTADO', 'LISTADO');
define('DEF_MSG_FORM_SELECCION', 'SELECCION MULTIPLE');
define('DEF_MSG_FORM_REPORTE', 'FILTROS DEL REPORTE');
define('DEF_MSG_SIN_REGISTROS', 'Aviso del Sistema, no existen registros disponibles.');
define('DEF_MSG_FORM_AVISO', 'Aviso del Sistema, Upps! acción no permitida, ');
define('DEF_MSG_FORM_AVISO_OK', 'Aviso del Sistema, Muy Bien! ');
define('DEF_TIPOUSER_ESTINT', 'EST_INT');
define('DEF_TIPOUSER_ESTEXT', 'EST_EXT');
define('DEF_TIPOUSER_INST', 'USER_INST');
define('DEF_EDAD_NIN_MIN', '3');
define('DEF_EDAD_NIN_MAX', '11');
define('DEF_EDAD_ADO_MIN', '12');
define('DEF_EDAD_ADO_MAX', '17');
define('DEF_EDAD_JOV_MIN', '18');
define('DEF_EDAD_JOV_MAX', '40');

// ++++++++++++++++++++++++++++++++++++ //
// Rutas HTML
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_PATH_HTML_EMPRESA','mae_empresa_html.php');
define('DEF_PATH_HTML_TIPO_DOC','mae_tipodoc_html.php');
define('DEF_PATH_HTML_MONEDA','mae_moneda_html.php');
define('DEF_PATH_HTML_FORMAPAGO','mae_formapago_html.php');
define('DEF_PATH_HTML_MEDIOPAGO','mae_mediopago_html.php');
define('DEF_PATH_HTML_TIPOGRADO','mae_tipogrado_html.php');
define('DEF_PATH_HTML_CATTURNO','mae_catturno_html.php');
define('DEF_PATH_HTML_TIPOASIS','mae_tipoasis_html.php');
define('DEF_PATH_HTML_CINTURON','mae_cinturon_html.php');
define('DEF_PATH_HTML_TARIFA','mae_tarifa_html.php');
define('DEF_PATH_HTML_SEDE','mae_sede_html.php');
define('DEF_PATH_HTML_INSTRUCTOR','mae_instructor_html.php');
define('DEF_PATH_HTML_ESTUDIANTE','mae_estudiante_html.php');
define('DEF_PATH_HTML_SEDEINSTRUCTOR','mae_sedeinstructor_html.php');
define('DEF_PATH_HTML_ESTUDIANTEXT','mae_estudiantext_html.php');
define('DEF_PATH_HTML_EXAMEN','mae_examen_html.php');
define('DEF_PATH_HTML_EXAMENDET','mae_examendet_html.php');
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_PATH_HTML_HORARIO','mov_horario_html.php');
define('DEF_PATH_HTML_HORARIOPROG','mov_horarioclase_html.php');
define('DEF_PATH_HTML_MATRICULA_HORARIO','mov_matriculahorario_html.php');
define('DEF_PATH_HTML_MATRICULA','mov_matricula_html.php');
define('DEF_PATH_HTML_ASISTENCIA','mov_asistencia_html.php');
define('DEF_PATH_HTML_PAGO','mov_pago_html.php');
define('DEF_PATH_HTML_EVENTO','mov_evento_html.php');
define('DEF_PATH_HTML_EVENTOASISTENCIA','mov_eventoasistencia_html.php');
define('DEF_PATH_HTML_PROMOCION','mov_promocion_html.php');
define('DEF_PATH_HTML_PROMOCIONADO','mov_promocionado_html.php');
define('DEF_PATH_HTML_PROMOCIONEXT','mov_promocionext_html.php');
define('DEF_PATH_HTML_PROMOCIONADOEXT','mov_promocionadoext_html.php');
define('DEF_PATH_HTML_EVALUACION','mov_evaluacion_html.php');
define('DEF_PATH_HTML_ACADEMIA','mae_academia_html.php');
define('DEF_PATH_HTML_TRASLADO','mov_traslado_html.php');

// ++++++++++++++++++++++++++++++++++++ //
define('DEF_PATH_HTML_RPT_EXTXSEDE','rpt_estudiante_x_sede_html.php');
define('DEF_PATH_HTML_RPT_MATXHORARIO','rpt_matricula_x_horario_html.php');
define('DEF_PATH_HTML_RPT_CREDITOS','rpt_creditos_html.php');
define('DEF_PATH_HTML_RPT_ASISXHORARIO','rpt_asistencia_x_horario_html.php');
define('DEF_PATH_HTML_RPT_INGXPERIODO','rpt_ingresos_x_periodo_html.php');
define('DEF_PATH_HTML_RPT_TRASLADOSPEND','rpt_traslados_pendientes_html.php');
define('DEF_PATH_HTML_RPT_CUADREINGRESOS','rpt_cuadre_ingresos_html.php');

// ++++++++++++++++++++++++++++++++++++ //
define('DEF_PATH_HTML_ROL','mae_rol_html.php');
define('DEF_PATH_HTML_USUARIO','mae_usuario_html.php');
define('DEF_PATH_HTML_ROLUSUARIO','mae_rolusuario_html.php');
define('DEF_PATH_HTML_ROLOPCION','mae_rolopcion_html.php');

// ++++++++++++++++++++++++++++++++++++ //
// Tablas
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_TABLA_EMPRESA', 'MAE_EMPRESA');
define('DEF_TABLA_PANEL', 'PANEL_ADMIN');
define('DEF_TABLA_TIPO_DOC', 'MAE_TIPO_DOC');
define('DEF_TABLA_MONEDA', 'MAE_MONEDA');
define('DEF_TABLA_FORMAPAGO', 'MAE_FORMA_PAGO');
define('DEF_TABLA_MEDIOPAGO', 'MAE_MEDIO_PAGO');
define('DEF_TABLA_TIPOGRADO', 'MAE_TIPO_GRADO');
define('DEF_TABLA_CATTURNO', 'MAE_CAT_TURNO');
define('DEF_TABLA_TIPOASIS', 'MAE_TIPO_ASISTENCIA');
define('DEF_TABLA_PAIS', 'MAE_PAIS');
define('DEF_TABLA_CINTURON', 'MAE_CINTURON');
define('DEF_TABLA_TARIFA', 'MAE_TARIFA');
define('DEF_TABLA_SEDE', 'MAE_SEDE');
define('DEF_TABLA_INSTRUCTOR', 'MAE_INSTRUCTOR');
define('DEF_TABLA_CATESTUDIANTE', 'MAE_CAT_ESTUDIANTE');
define('DEF_TABLA_ESTUDIANTE', 'MAE_ESTUDIANTE');
define('DEF_TABLA_ESTUDIANTE_CINTURON', 'MAE_ESTUDIANTE_CINTURON');
define('DEF_TABLA_SEDEINSTRUCTOR', 'MAE_SEDE_INSTRUCTOR');
define('DEF_TABLA_ESTUDIANTEXT', 'MAE_ESTUDIANTEXT');
define('DEF_TABLA_EXAMEN', 'MAE_EXAMEN');
define('DEF_TABLA_EXAMENDET', 'MAE_EXAMEN_DET');
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_TABLA_HORARIO', 'MOV_HORARIO');
define('DEF_TABLA_HORARIOPROG', 'MOV_HORARIO_PROG');
define('DEF_TABLA_HORARIOAYUDA', 'MOV_HORARIO_AYUDANTE');
define('DEF_TABLA_MATRICULA', 'MOV_MATRICULA');
define('DEF_TABLA_ASISTENCIA', 'MOV_ASISTENCIA');
define('DEF_TABLA_PAGO', 'MOV_PAGO');
define('DEF_TABLA_EVENTO', 'MOV_EVENTO');
define('DEF_TABLA_EVENTOPROG', 'MOV_EVENTO_PROG');
define('DEF_TABLA_PROMOCION', 'MOV_PROMOCION');
define('DEF_TABLA_PROMOCIONPROG', 'MOV_PROMOCION_PROG');
define('DEF_TABLA_PROMOCIONEXT', 'MOV_PROMOCION_EXT');
define('DEF_TABLA_PROMOCIONEXTPROG', 'MOV_PROMOCION_PROG_EXT');
define('DEF_TABLA_EVALUACION', 'MOV_EVALUACION');
define('DEF_TABLA_EVALUACIONDET', 'MOV_EVALUACION_DET');
define('DEF_TABLA_ACADEMIA', 'MAE_ACADEMIA');
define('DEF_TABLA_TRASLADO', 'MOV_TRASLADO');
define('DEF_TABLA_TRASLADO_APROB','MOV_TRASLADO_APROB');
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_TABLA_RPT_ESTXSEDE', 'RPT_EST_X_SEDE');
define('DEF_TABLA_RPT_MATXHORARIO', 'RPT_MAT_X_HORARIO');
define('DEF_TABLA_RPT_CREDITOS', 'RPT_CREDITOS');
define('DEF_TABLA_RPT_ASISXHORARIO', 'RPT_ASISTENCIA_X_HORARIO');
define('DEF_TABLA_RPT_INGXPERIODO', 'RPT_INGRESOS_X_PERIODO');
define('DEF_TABLA_RPT_TRASLADOSPEND', 'RPT_TRASLADOS_PENDIENTES');
define('DEF_TABLA_RPT_CUADREINGRESOS', 'RPT_CUADRE_INGRESOS');
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_TABLA_MENU_NIVEL', 'MAE_MENU_NIVEL');
define('DEF_TABLA_MENU_OPC', 'MAE_MENU_OPCION');
define('DEF_TABLA_ROL', 'MAE_ROL');
define('DEF_TABLA_USUARIO', 'MAE_USUARIO');
define('DEF_TABLA_TIPOUSUARIO', 'MAE_TIPO_USUARIO');
define('DEF_TABLA_ROLUSUARIO', 'MAE_ROL_USUARIO');
define('DEF_TABLA_ROLOPCION', 'MAE_ROL_OPCION');

// ++++++++++++++++++++++++++++++++++++ //
// Tamaño dimensiones para fotos
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_UPLOAD_CINTURON_DIR', 'cinturon');
define("DEF_UPLOAD_CINTURON_W", 160);
define("DEF_UPLOAD_CINTURON_H", 160);
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_UPLOAD_SEDE_DIR', 'sede');
define("DEF_UPLOAD_SEDE_W", 400);
define("DEF_UPLOAD_SEDE_H", 400);
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_UPLOAD_INSTRUCTOR_DIR', 'instructor');
define("DEF_UPLOAD_INSTRUCTOR_W", 160);
define("DEF_UPLOAD_INSTRUCTOR_H", 160);
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_UPLOAD_ESTUDIANTE_DIR', 'estudiante');
define("DEF_UPLOAD_ESTUDIANTE_W", 160);
define("DEF_UPLOAD_ESTUDIANTE_H", 160);
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_UPLOAD_USUARIO_DIR', 'usuario');
define("DEF_UPLOAD_USUARIO_W", 160);
define("DEF_UPLOAD_USUARIO_H", 160);
// ++++++++++++++++++++++++++++++++++++ //
define('DEF_UPLOAD_EMPRESA_DIR', 'images');
define("DEF_UPLOAD_EMPRESA_W", 160);
define("DEF_UPLOAD_EMPRESA_H", 160);
// ++++++++++++++++++++++++++++++++++++ //

define('DIR_UPLOAD_INFO', 'info');
define("IMG_LOGO_ANCHO", 128);
define("IMG_LOGO_ALTO", 128);

// ++++++++++++++++++++++++++++++++++++ //



?>