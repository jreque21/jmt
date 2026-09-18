<?php

// Incluye Librería BD
require_once("../config/funciones.php");

// Lista de Usuarios (Cuerpo - Drcha)
function f_listado($as_titulo, $as_icono, $as_msgRpta){

	// Enlaces
	$url_nuevo		= "mov_horario_nuevo.php";
	$url_editar		= "mov_horario_editar.php";
	$url_lista		= "mov_horario_lista.php";
	$url_promocion	= "../controlador/mov_horario_aperturar.php";
	$url_ayudante	= "mov_horarioayuda_editar.php";
	$url_finaliza	= "../controlador/mov_horario_finalizar.php";
	$url_eliminar	= "../controlador/mov_horario_eliminar.php";

	// Instanciar clase
	$crud = new crud();

	// Armar Estructura
	$array_campo_pk = [];
	$array_valor_pk = [];

	// Listado
	$array = $crud->fila_listar(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'D_FEC_INICIO', 'D', 0, 1000);

	?>

	<!-- Sección Contenido -->
	<div class="content-wrapper">

		<!-- Cabecera de Sección Contenido -->
		<section class="content-header">
			<h1>
				<i class="<?php echo $as_icono;?>"></i> <?php echo $as_titulo;?>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo DEF_URL_LOGIN;?>"><i class="fa fa-home"></i> Inicio</a></li>
			</ol>
		</section>
		<!-- Fin de Cabecera de Sección Contenido -->

		<!-- Contenido -->
		<section class="content">

			<?php
			if($as_msgRpta) {
				if (substr($as_msgRpta,0,2)=='OK'){
					echo "<div class='alert alert-success'>";
						echo DEF_MSG_FORM_AVISO_OK.substr($as_msgRpta,3);
					echo "</div>";
				}else{
					echo "<div class='alert alert-danger'>";
						echo DEF_MSG_FORM_AVISO.$as_msgRpta;
					echo "</div>";
				}
			}
			?>
			<!-- Fila Principal -->
			<div class="row">

				<!-- Columna Izquierda -->
				<section class="col-lg-12 connectedSortable">

					<!-- Panel -->
					<div class="panel panel-primary">

						<!-- Cabecera -->
						<div class="box-header">
							<i class="ion ion-clipboard"></i>
							MANTENIMIENTO - <?php echo DEF_MSG_FORM_LISTADO;?>
						</div>

						<!-- Cuerpo -->
						<div class="panel-body">

							<?php
							if (!($array)) {
								?>
								<div class="alert alert-warning">
									<?php echo DEF_MSG_SIN_REGISTROS;?>
								</div>
								<?php
							}else {
								?>
								<div class="table-responsive">

									<table id="lista" class="table table-striped table-bordered table-hover">

										<thead>
											<tr>
												<th>Horario</th>
												<th>Sede</th>
												<th>Instructor</th>
												<th>Fecha Inicio</th>
												<th>Turno</th>
												<th>Hora</th>
												<th>Categoría</th>
												<th>Estado</th>
												<th>Acciones</th>
											</tr>
										</thead>

										<tbody>
											<?php
											while ($row = mysqli_fetch_assoc($array)) {
												$url_editar_fila    = $url_editar."?id_codigo=".($row["N_COD_HORARIO"]);
												$url_promocion_fila	= $url_promocion."?id_codigo=".($row["N_COD_HORARIO"]);
												$url_ayudante_fila	= $url_ayudante."?id_codigo=".($row["N_COD_HORARIO"]);
												$url_finaliza_fila	= $url_finaliza."?id_codigo=".($row["N_COD_HORARIO"]);
												?>
												<tr>
													<?php
													echo "<td>";
													echo f_r_url($url_editar_fila, $row["V_DESCRIPCION"],$row["V_OBSERVACION"]);
													echo "</td>";

													// Sede
													$array_campo_pk	= array('N_COD_SEDE');
													$array_valor_pk	= array($row["N_COD_SEDE"]);
													$ls_sede		= $crud->fila_recuperar_campo(DEF_TABLA_SEDE, $array_campo_pk, $array_valor_pk, 'V_NOMBRE');
													echo "<td>";
													echo $ls_sede;
													echo "</td>";

													// Instructor
													$array_campo_pk	= array('N_COD_INSTRUCTOR');
													$array_valor_pk	= array($row["N_COD_INSTRUCTOR"]);
													$ls_instructor_ape_p	= $crud->fila_recuperar_campo(DEF_TABLA_INSTRUCTOR, $array_campo_pk, $array_valor_pk, 'V_APE_PATERNO');
													$ls_instructor_ape_m	= $crud->fila_recuperar_campo(DEF_TABLA_INSTRUCTOR, $array_campo_pk, $array_valor_pk, 'V_APE_MATERNO');
													$ls_instructor_nombres	= $crud->fila_recuperar_campo(DEF_TABLA_INSTRUCTOR, $array_campo_pk, $array_valor_pk, 'V_NOMBRES');
													echo "<td>";
													echo $ls_instructor_ape_p.' '.$ls_instructor_ape_m.' '.$ls_instructor_nombres;
													echo "</td>";

													echo "<td>";
													echo $row["D_FEC_INICIO"];
													echo "</td>";

													// Turno
													$array_campo_pk	= array('N_COD_CATURNO');
													$array_valor_pk	= array($row["N_COD_CATURNO"]);
													$ls_turno		= $crud->fila_recuperar_campo(DEF_TABLA_CATTURNO, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
													echo "<td>";
													echo $ls_turno;
													echo "</td>";

													echo "<td>";
													echo substr($row["D_HORA_INICIO"],0,5);
													//echo date("H:i");
													echo "</td>";
													
													// Categoria Estudiante
													$array_campo_pk	= array('N_COD_CATESTUDIANTE');
													$array_valor_pk	= array($row["N_COD_CATESTUDIANTE"]);
													$ls_catestudiante= $crud->fila_recuperar_campo(DEF_TABLA_CATESTUDIANTE, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
													echo "<td>";
													echo $ls_catestudiante;
													echo "</td>";

													echo "<td>";
														$ls_estado =  $row["V_FLAG_ESTADO"];
														if ($ls_estado =='0') $ls_des_estado = 'Cancelado';
														if ($ls_estado =='1') $ls_des_estado = 'Registrado';
														if ($ls_estado =='2') $ls_des_estado = 'Aperturado';
														if ($ls_estado =='3') $ls_des_estado = 'Cerrado';
														echo $ls_des_estado;
													echo "</td>";

													echo "<td align='center'>";
													?>
													<a href="<?php echo $url_editar_fila?>">
														<i class="fa fa-edit" title = "Editar registro"></i>
													</a>&nbsp;
													<a href="<?php echo $url_ayudante_fila?>">
														<i class="fa fa-odnoklassniki" title = "Ayudantes Instructores"></i>
													</a>&nbsp;
													<a href="<?php echo $url_promocion_fila?>">
														<i class="fa fa-bullhorn" title = "Aperturar Horario"></i>
													</a>&nbsp;
													<a href="<?php echo $url_finaliza_fila?>">
														<i class="fa fa-flag-checkered" title = "Finalizar Horario"></i>  
													</a>
													<?php
													echo "</td>";

												echo "</tr>";
											}
											?>
										</tbody>

									</table>

								</div>

							<?php
							}
						?>
						<!-- Fin Cuerpo -->
						</div>

					</div>
					<!-- Fin Panel -->

					<a class="btn btn-primary" href="<?php echo $url_nuevo?>" role="button">
						<span class="glyphicon glyphicon-plus"></span>&nbsp;Nuevo Horario
					</a>

					</br>

				</section>
				<!-- Fin Columna Izquierda -->

			</div>
			<!-- Fin Fila Principal -->

		</section>
		<!-- Fin Contenido -->

	</div>
	<!-- Fin sección Contenido -->

<?php
}

// Formulario de Registro
function f_formulario($as_titulo, $as_icono, $as_msgRpta, $array = "") {

	//Inicalizando variables
	$lb_edit = is_array($array);
	$inhabilitado = "disabled='disabled'";

	// Instanciar clase
	$crud = new crud();

	// Enlaces
	$url_lista		= "mov_horario_lista.php";
	$url_registrar	= "../controlador/mov_horario_registrar.php";
	$url_actualizar	= "../controlador/mov_horario_actualizar.php";
	$url_eliminar	= "../controlador/mov_horario_eliminar.php";

	// Parámetros
	$li_horasxclase = $crud->f_get_param('N_HORASXCLASE');
	$li_sesiones 	= $crud->f_get_param('N_CLASESXHORARIO');
	$li_min_est 	= $crud->f_get_param('N_MIN_ESTUDIANTES');
	$li_max_est		= $crud->f_get_param('N_MAX_ESTUDIANTES');
	
	if($lb_edit) {
		$ls_modo = DEF_MSG_FORM_EDICION;
	}else{
		$ls_modo = DEF_MSG_FORM_NUEVO;
	}

	// Formulario HTML
	?>

	<!-- Sección Contenido -->
	<div class="content-wrapper">

		<!-- Cabecera de Sección Contenido -->
		<section class="content-header">
			<h1>
				<i class="<?php echo $as_icono;?>"></i> <?php echo $as_titulo;?>
			</h1>
			<ol class="breadcrumb">
			<li><a href="<?php echo DEF_URL_LOGIN;?>"><i class="fa fa-home"></i> Inicio</a></li>
				<li class="active"><a href="<?php echo $url_lista?>">Volver a Lista</a></li>
			</ol>
		</section>
		<!-- Fin de Cabecera de Sección Contenido -->

		<!-- Contenido -->
		<section class="content">
			
			<?php
			if($as_msgRpta) {
				echo "<div class='alert alert-danger'>";
					echo DEF_MSG_FORM_AVISO.$as_msgRpta;
				echo "</div>";
			}
			?>
			
			<!-- Fila Principal -->
			<div class="row">

				<!-- Columna Izquierda -->
				<section class="col-lg-12 connectedSortable">

					<!-- Panel -->
					<div class="panel panel-primary">

						<!-- Cabecera -->
						<div class="box-header">
							<i class="fa fa-edit"></i>
							MANTENIMIENTO - <?php echo strtoupper($ls_modo);?>
						</div>

						<!-- Cuerpo -->
						<div class="panel-body">

							<form  id="form_mtto" role="form" method="post" action="" enctype="multipart/form-data" autocomplete="off">
								
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_codigo">Código</label>
											<input type="text" class="form-control" id="id_codigo" name="id_codigo" maxlength="5" disabled
												title = "Generado por el sistema" placeholder="Codigo autogenerado" value="<?php echo $lb_edit?$array["N_COD_HORARIO"]:""; ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_sede">Sede</label>
											<select class="form-control" id="id_cod_sede" name="id_cod_sede" required>
												<?php												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_SEDE, $array_campo_pk, $array_valor_pk, 'V_NOMBRE', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_SEDE"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_SEDE"] == $array["N_COD_SEDE"]){
														echo " selected";
													}
													echo ">";
													echo $this_tipo["V_NOMBRE"];
													echo "\n";
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_flag_estado">Estado</label>
											<?php
											if($lb_edit) {
												$ls_fg_estado = $array["V_FLAG_ESTADO"];
											}else{	
												$ls_fg_estado = '1';
											}
											?>
											<select class="form-control" id="id_flag_estado" name="id_flag_estado">
											<option value="1"<?php if("1" == $ls_fg_estado) echo "selected";?>>Registrado</option>
											<option value="2"<?php if("2" == $ls_fg_estado) echo "selected";?>>Aperturado</option>
											<option value="3"<?php if("3" == $ls_fg_estado) echo "selected";?>>Terminado</option>
											<option value="0"<?php if("0" == $ls_fg_estado) echo "selected";?>>Cancelado</option>
											</select>			
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_descripcion">Descripción</label>
											<input type="text" class="form-control" id="id_descripcion" name="id_descripcion" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 -_]{1,150}" autofocus
												title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Abril 2023 Turno 5pm" value="<?php echo $lb_edit?$array["V_DESCRIPCION"]:""; ?>"> 
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_catturno">Turno</label>
											<select class="form-control" id="id_cod_catturno" name="id_cod_catturno" required>
												<?php												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_CATTURNO, $array_campo_pk, $array_valor_pk, 'N_COD_CATURNO', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_CATURNO"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_CATURNO"] == $array["N_COD_CATURNO"]){
														echo " selected";
													}
													echo ">";
													echo $this_tipo["V_DES_CORTA"];
													echo "\n";
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_instructor">Instructor</label>
											<select class="form-control" id="id_cod_instructor" name="id_cod_instructor" required>
												<?php												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_INSTRUCTOR, $array_campo_pk, $array_valor_pk, 'V_APE_PATERNO, V_APE_MATERNO', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_INSTRUCTOR"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_INSTRUCTOR"] == $array["N_COD_INSTRUCTOR"]){
														echo " selected";
													}
													echo ">";
													echo $this_tipo["V_APE_PATERNO"].' '.$this_tipo["V_APE_MATERNO"].' '.$this_tipo["V_NOMBRES"];
													echo "\n";
												}
												?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_catestudiante">Categoria</label>
											<select class="form-control" id="id_cod_catestudiante" name="id_cod_catestudiante" required pattern="[1-9999]">
												<?php												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_CATESTUDIANTE, $array_campo_pk, $array_valor_pk, 'N_COD_CATESTUDIANTE', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_CATESTUDIANTE"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_CATESTUDIANTE"] == $array["N_COD_CATESTUDIANTE"]){
														echo " selected";
													}
													echo ">";
													echo $this_tipo["V_DES_CORTA"];
													echo "\n";
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_cinturon">Cinturón</label>
											<select class="form-control" id="id_cod_cinturon" name="id_cod_cinturon">
												<?php												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_CINTURON, $array_campo_pk, $array_valor_pk, 'N_ORDEN', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_CINTURON"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_CINTURON"] == $array["N_COD_CINTURON"]){
														echo " selected";
													}
													echo ">";
													echo $this_tipo["V_DES_CORTA"];
													echo "\n";
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_tarifa">Tarifa</label>
											<select class="form-control" id="id_cod_tarifa" name="id_cod_tarifa" required>
												<?php												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_TARIFA, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_TARIFA"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_TARIFA"] == $array["N_COD_TARIFA"]){
														echo " selected";
													}
													echo ">";
													echo $this_tipo["V_DES_CORTA"];
													echo "\n";
												}
												?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_fec_inicio">Fecha de Inicio</label>
											<input type="date" class="form-control input-sm" id="id_fec_inicio" name="id_fec_inicio" required"
												title = "Formato Fecha" value="<?php echo $lb_edit?$array["D_FEC_INICIO"]:""; ?>"> 
										</div>	
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_hora_inicio">Hora de Inicio</label>
											<input type="time" class="form-control input-sm" id="id_hora_inicio" name="id_hora_inicio" required"
												title = "Formato Hora" value="<?php echo $lb_edit?$array["D_HORA_INICIO"]:""; ?>"> 
										</div>	
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_horas">Horas por clase</label>
											<input type="number" class="form-control" id="id_horas" name="id_horas" maxlength="3" required pattern="[0-9 ]{1,3}"
												title = "Números. Tamaño máximo: 3" placeholder="(*) Ejemplo : 1" value="<?php echo $lb_edit?$array["N_HORAS"]:$li_horasxclase; ?>"> 
										</div>
									</div>
								</div>
	
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_sesiones">Numero de Clases</label>
											<input type="number" class="form-control" id="id_sesiones" name="id_sesiones" maxlength="3" required pattern="[0-9 ]{1,3}"
												title = "Números. Tamaño máximo: 3" placeholder="(*) Ejemplo : 12" value="<?php echo $lb_edit?$array["N_SESIONES"]:$li_sesiones; ?>"> 
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_estudiantes_min">Min. Estudiantes</label>
											<input type="number" class="form-control" id="id_estudiantes_min" name="id_estudiantes_min" maxlength="3" required pattern="[0-9 ]{1,3}"
												title = "Números. Tamaño máximo: 3" placeholder="(*) Ejemplo : 15" value="<?php echo $lb_edit?$array["N_ESTUDIANTES_MIN"]:$li_min_est; ?>"> 
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_estudiantes_max">Max. Estudiantes</label>
											<input type="number" class="form-control" id="id_estudiantes_max" name="id_estudiantes_max" maxlength="3" pattern="[0-9 ]{1,3}"
												title = "Números. Tamaño máximo: 3" placeholder="(*) Ejemplo : 50" value="<?php echo $lb_edit?$array["N_ESTUDIANTES_MAX"]:$li_max_est; ?>"> 
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-4">
										<label for="id_dias">Marcar dias de clase </label>
										<div class="checkbox">
											<?php
											if($lb_edit) {
												$ls_fg_dia2 = $array['V_FLAG_DIA_2'];
											}else{
												$ls_fg_dia2 = '0';
											}
											?>
											<label>
											<input type="checkbox" id="id_flag_dia_2" name="id_flag_dia_2" <?php if("0" <> $ls_fg_dia2) echo "checked";?> value="1"> Lunes
											</label>
										</div>
										<div class="checkbox">
											<?php
											if($lb_edit) {
												$ls_fg_dia3 = $array['V_FLAG_DIA_3'];
											}else{
												$ls_fg_dia3 = '0';
											}
											?>
											<label>
											<input type="checkbox" id="id_flag_dia_3" name="id_flag_dia_3" <?php if("0" <> $ls_fg_dia3) echo "checked";?> value="1"> Martes
											</label>
										</div>
										<div class="checkbox">
											<?php
											if($lb_edit) {
												$ls_fg_dia4 = $array['V_FLAG_DIA_4'];
											}else{
												$ls_fg_dia4 = '0';
											}
											?>
											<label>
											<input type="checkbox" id="id_flag_dia_4" name="id_flag_dia_4" <?php if("0" <> $ls_fg_dia4) echo "checked";?> value="1"> Miércoles
											</label>
										</div>
										<div class="checkbox">
											<?php
											if($lb_edit) {
												$ls_fg_dia5 = $array['V_FLAG_DIA_5'];
											}else{
												$ls_fg_dia5 = '0';
											}
											?>
											<label>
											<input type="checkbox" id="id_flag_dia_5" name="id_flag_dia_5" <?php if("0" <> $ls_fg_dia5) echo "checked";?> value="1"> Jueves
											</label>
										</div>
										<div class="checkbox">
											<?php
											if($lb_edit) {
												$ls_fg_dia6 = $array['V_FLAG_DIA_6'];
											}else{
												$ls_fg_dia6 = '0';
											}
											?>
											<label>
											<input type="checkbox" id="id_flag_dia_6" name="id_flag_dia_6" <?php if("0" <> $ls_fg_dia6) echo "checked";?> value="1"> Viernes
											</label>
										</div>
										<div class="checkbox">
											<?php
											if($lb_edit) {
												$ls_fg_dia7 = $array['V_FLAG_DIA_7'];
											}else{
												$ls_fg_dia7 = '0';
											}
											?>
											<label>
											<input type="checkbox" id="id_flag_dia_7" name="id_flag_dia_7" <?php if("0" <> $ls_fg_dia7) echo "checked";?> value="1"> Sábado
											</label>
										</div>
										<div class="checkbox">
											<?php
											if($lb_edit) {
												$ls_fg_dia1 = $array['V_FLAG_DIA_1'];
											}else{
												$ls_fg_dia1 = '0';
											}
											?>
											<label>
											<input type="checkbox" id="id_flag_dia_1" name="id_flag_dia_1" <?php if("0" <> $ls_fg_dia1) echo "checked";?> value="1"> Domingo
											</label>
										</div>
									</div>
									<div class="col-sm-8">
										<div class="form-group">
											<label for="id_observacion">Observaciones</label>
											<textarea class="form-control" rows="8" id="id_observacion" name="id_observacion" placeholder="Ejemplo : Fecha de inicio reprogramado"><?php echo $lb_edit?$array["V_OBSERVACION"]:""; ?></textarea>
										</div>	
									</div>
								</div>	

								<?php
								if ($lb_edit) {
									echo "<input type=hidden name=id_codigo value=\"".$array["N_COD_HORARIO"]."\">";
									?>
									<input class="btn btn-success" type="submit" id ="btn_actualizar" value="Actualizar" onclick=this.form.action="<?php echo $url_actualizar?>">
									<input class="btn btn-danger" type="submit" id ="btn_eliminar" value="Eliminar" formnovalidate onclick=this.form.action="<?php echo $url_eliminar?>">
									<input class="btn btn-primary" type="submit" id ="btn_cancelar"  value="Cancelar" formnovalidate onclick=this.form.action="<?php echo $url_lista?>">
									<?php
								} else {
									?>
									<input class="btn btn-success" type="submit" id ="btn_agregar" value="Guardar" onclick=this.form.action="<?php echo $url_registrar?>">
									<input class="btn btn-primary" type="submit" id ="btn_cancelar"  value="Cancelar" formnovalidate onclick=this.form.action="<?php echo $url_lista?>">
									<?php
								}
								?>
			
							</form>
							
						</div>
						<!-- Fin Cuerpo -->

					</div>
					<!-- Fin Panel -->

				</section>
				<!-- Fin Columna Izquierda -->

			</div>
			<!-- Fin Fila Principal -->

		</section>
		<!-- Fin Contenido -->

	</div>
	<!-- Fin sección Contenido -->

	<script src="../recursos/js/jquery-1.11.2.min.js"></script>
	
	<?php
}

// Formulario de Registro Ayuda
function f_formulario_ayuda($as_titulo, $as_icono, $as_msgRpta, $id = "") {

	//Inicalizando variables
	$inhabilitado = "disabled='disabled'";

	// Instanciar clase
	$crud = new crud();

	// Definir Estructura
	$array_campo_pk = array('N_COD_HORARIO');
	$array_valor_pk = array($id);

	// Listado
	$array = $crud->fila_listar(DEF_TABLA_HORARIOAYUDA, $array_campo_pk, $array_valor_pk, 'N_COD_INSTRUCTOR', 'A', 0, 100);

	// Datos Padre
	$array_campo_pk	= array('N_COD_HORARIO');
	$array_valor_pk	= array($id);
	$ls_subtitulo	= $crud->fila_recuperar_campo(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');

	// Enlaces
	$url_lista		= "mov_horario_lista.php";
	$ls_modo 		= DEF_MSG_FORM_SELECCION;

	// Formulario HTML
	?>

	<!-- Sección Contenido -->
	<div class="content-wrapper">

		<!-- Cabecera de Sección Contenido -->
		<section class="content-header">
			<h1>
				<i class="<?php echo $as_icono;?>"></i> <?php echo $as_titulo;?>				
			</h1>
			</br>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page"><b>Horario : </b><?php echo $ls_subtitulo;?></li>
				</ol>
			</nav>
			<ol class="breadcrumb">
				<li><a href="<?php echo DEF_URL_LOGIN;?>"><i class="fa fa-home"></i> Inicio</a></li>
				<li class="active"><a href="<?php echo $url_lista?>">Volver a Lista</a></li>
			</ol>
		</section>
		<!-- Fin de Cabecera de Sección Contenido -->

		<!-- Contenido -->
		<section class="content">
			
			<?php
			if($as_msgRpta) {
				echo "<div class='alert alert-danger'>";
					echo DEF_MSG_FORM_AVISO.$as_msgRpta;
				echo "</div>";
			}
			?>
			
			<!-- Fila Principal -->
			<div class="row">

				<!-- Columna Izquierda -->
				<section class="col-lg-12 connectedSortable">

					<!-- Panel -->
					<div class="panel panel-primary">

						<!-- Cabecera -->
						<div class="box-header">
							<i class="fa fa-edit"></i>
							MANTENIMIENTO - <?php echo strtoupper($ls_modo);?>
						</div>

						<!-- Cuerpo -->
						<div class="panel-body">

							<?php
							if (!($array)) {
								?>
								<div class="alert alert-warning">
									<?php echo DEF_MSG_SIN_REGISTROS;?>
								</div>
								<?php
							}else {
								?>
								<form  id="form_mtto" role="form" method="post" action="" autocomplete="off">

								<div class="table-responsive">

									<table id="lista" class="table table-striped table-bordered">

										<thead>
											<tr>
												<th>Marca (S/N)</th>
												<th>Nombre Instructor</th>
												<th>Cinturón (Grado)</th>
											</tr>
										</thead>

										<tbody id='detalle'>
											<?php
											$li_check = 0;
											while ($row = mysqli_fetch_assoc($array)) {
												?>
												<tr>
													
													<td>
														<div class="checkbox">
															<label>
															<input type="checkbox" data-idRegistro = "<?php echo $row["N_COD_INSTRUCTOR"];?>" name="id_flag_estado" <?php if("0" <> $row["V_FLAG_ESTADO"]) echo "checked";?> value="<?php echo $li_check; ?>">
															</label>
														</div>
													</td>

													<?php
													echo "<input type=hidden id = id_codigo_padre name=id_codigo_padre value=\"".$id."\">";
													
													// Datos Instructor
													$array_campo_pk	= array('N_COD_INSTRUCTOR');
													$array_valor_pk	= array($row["N_COD_INSTRUCTOR"]);
													$ls_apepaterno	= $crud->fila_recuperar_campo('MAE_INSTRUCTOR', $array_campo_pk, $array_valor_pk, 'V_APE_PATERNO');
													$ls_apematerno	= $crud->fila_recuperar_campo('MAE_INSTRUCTOR', $array_campo_pk, $array_valor_pk, 'V_APE_MATERNO');
													$ls_nombres		= $crud->fila_recuperar_campo('MAE_INSTRUCTOR', $array_campo_pk, $array_valor_pk, 'V_NOMBRES');
													$ls_datos		= $ls_apepaterno.' '.$ls_apematerno.' '.$ls_nombres;
													$ls_cod_cinturon= $crud->fila_recuperar_campo('MAE_INSTRUCTOR', $array_campo_pk, $array_valor_pk, 'N_COD_CINTURON');
													echo "<td>";
													echo $ls_datos;
													echo "</td>";

													// Datos Cinturon
													$array_campo_pk	= array('N_COD_CINTURON');
													$array_valor_pk	= array($ls_cod_cinturon);
													$ls_grado		= $crud->fila_recuperar_campo('MAE_CINTURON', $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
													echo "<td>";
													echo $ls_grado;
													echo "</td>";

												echo "</tr>";
												$li_check++;
											}
											?>
										</tbody>

									</table>

								</div>
								
								<input class="btn btn-primary" type="submit" id ="btn_cancelar"  value="Regresar" formnovalidate onclick=this.form.action="<?php echo $url_lista?>">
								&nbsp;&nbsp;&nbsp;<span id="span_rpta"></span>
								
							</form>

							<?php
							}
						?>
						<!-- Fin Cuerpo -->
						</div>
						
					</div>
					<!-- Fin Panel -->
					
				</section>
				<!-- Fin Columna Izquierda -->

			</div>
			<!-- Fin Fila Principal -->

		</section>
		<!-- Fin Contenido -->

	</div>
	<!-- Fin sección Contenido -->

	<script src="../recursos/js/jquery-1.11.2.min.js"></script>
	
	<script>
		$(function(){
			$('body').on('click', '#detalle input[type=checkbox]', function(event){
				var id_codigo = $(this).attr('data-idRegistro');
				var id_codigo_padre = $('#id_codigo_padre').val()
				id_marca = '0';
				if($(this).is(':checked')){
					id_marca = '1';
				}
				var parametros = {
					"id_codigo_padre" : id_codigo_padre,	
					"id_codigo" : id_codigo,
					"id_marca" : id_marca

				};
				$.ajax({
						data:  parametros,
						url:   '../controlador/mov_horarioayuda_actualizar.php',
						type:  'post',
						beforeSend: function () {
							$('#span_rpta').text(''); // Limpieza
							console.log("Procesando, espere por favor...");
						},
						success:  function (response) {
							if(response == '0'){
								$('#span_rpta').text('Estado : Acción completada con éxito...');
								alert('Ocurrio un problema, vuelva a intentar.');
							}else{
								$('#span_rpta').text('Estado : Acción completada con éxito...');
							}							
						}
				});
			});		
		});
	</script>	

	<?php
}

?>