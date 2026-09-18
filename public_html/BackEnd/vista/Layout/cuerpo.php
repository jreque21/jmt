<?php

// Incluye Libreria BD
require_once("../config/class_crud.php");

// Cuerpo - Izda
function f_admin_cuerpo_izda($id_nivel1, $id_nivel2){

// Instanciar clase
$crud = new crud();

// Niveles
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('1');
$array_nivel	= $crud->fila_listar('MAE_MENU_NIVEL', $array_campo_pk, $array_valor_pk, 'N_ORDEN', 'A', 0, 10);

// Informacion
$array_campo_info_pk	= array('V_COD_USER');
$array_valor_info_pk	= array($_SESSION['usr_conectado']);
$ls_data_nombre = $crud->fila_recuperar_campo("MAE_USUARIO", $array_campo_info_pk, $array_valor_info_pk,"V_NOMBRES"); 
$ls_data_imagen = $crud->fila_recuperar_campo("MAE_USUARIO", $array_campo_info_pk, $array_valor_info_pk,"V_FOTO"); 

// Gestionar sin foto
if ($ls_data_imagen == ""){
	$ls_data_imagen ='unnamed.jpg';
}
	
?>
	<!-- Columna Izquierda -->
    <aside class="main-sidebar">

        <!-- Seccion sidebar -->
        <section class="sidebar">
			
            <!-- Seccion Panel - Usuario -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="../../upload/usuario/<?php echo $ls_data_imagen?>" class="img-rounded" alt="Usuario">
                </div>
                <div class="pull-left info">
                    <p><?php echo $ls_data_nombre;?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- Fin Seccion Panel - Usuario -->

            <!-- Seccion items de Menu -->
            <ul class="sidebar-menu" data-widget="tree">
				
				<li class="header">PRINCIPAL</li>

				<!-- Recorre Niveles -->
				<?php				
				if ($array_nivel) {	
					while ($row_nivel = mysqli_fetch_assoc($array_nivel)) {
						
						// Treview
						if($row_nivel["N_COD_NIVEL"] == $id_nivel1){
							echo "<li class='active treeview'>";
						}else{
							echo "<li class='treeview'>";
						}
						?>
													
							<a href="#">
								<i class="<?php echo $row_nivel["V_ICONO"];?>"></i> 
								<span><?php echo $row_nivel["V_NOMBRE"];?></span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							
							<ul class="treeview-menu">
								
								<?php
								
								// Almacenar nivel
								$nivel = $row_nivel["N_COD_NIVEL"];
								
								// Estructura de opciones
								$array_campo_pk	= array('V_FLAG_ESTADO', 'N_COD_NIVEL');
								$array_valor_pk	= array('1', $nivel);
								
								$array_opciones = $crud->fila_listar('MAE_MENU_OPCION', $array_campo_pk, $array_valor_pk, 'N_ORDEN', 'A', 0, 100);
								
								// Recorre opciones de Nivel
								if ($array_opciones) {	
									while ($row_opcion = mysqli_fetch_assoc($array_opciones)) {
										
										// Obtener permiso
										$li_permiso = $crud->f_usuario_acceso($_SESSION['usr_conectado'], $row_opcion["N_COD_OPCION"]);

										// <li> Opciones
										if($row_opcion["N_ORDEN"] == $id_nivel2 && $row_nivel["N_COD_NIVEL"] == $id_nivel1){
											echo "<li class='active'>";
										}else{
											echo "<li>";
										}
										
										// Gestionar permisos por opcion
										if ($li_permiso == 1) {
											?>
												<a href="<?php echo $row_opcion["V_URL"]?>">
													<i class="<?php echo $row_opcion["V_ICONO"]?>"></i> 
													<?php echo $row_opcion["V_NOMBRE"]?> 
												</a>
											</li>
											<?php
										}else{
											?>
												<a class="enlace_desactivado" href="<?php echo $row_opcion["V_URL"]?>">
													<i class="<?php echo $row_opcion["V_ICONO"]?>"></i> 
													<?php echo $row_opcion["V_NOMBRE"]?> 
												</a>
											</li>
											<?php	
										}													
										
									}
								}
								
								?>
							</ul>
					
						<?php
						echo "</li>";
					}
				}			
				?>
				    
            </ul>
            <!-- Fin Seccion items de Menu -->

        </section>
        <!-- Fin sidebar -->

    </aside>
    <!-- Fin Columna Izquierda -->
<?php
}

// Cuerpo - Drcha
function f_admin_cuerpo_drcha(){

// Instanciar clase
$crud = new crud();

// Cuenta Sedes
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('1');
$li_sedes   	= $crud->fila_contar('MAE_SEDE', $array_campo_pk, $array_valor_pk);	

// Cuenta Instructores
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('1');
$li_instructores= $crud->fila_contar('MAE_INSTRUCTOR', $array_campo_pk, $array_valor_pk);	

// Cuenta Estudiantes Internos
$array_campo_pk	= array('V_FLAG_ESTADO', 'V_TIPO_EST');
$array_valor_pk	= array('1', 'EST_INT');
$li_est_int 	= $crud->fila_contar('MAE_ESTUDIANTE', $array_campo_pk, $array_valor_pk);	

// Cuenta Estudiantes Externos
$array_campo_pk	= array('V_FLAG_ESTADO', 'V_TIPO_EST');
$array_valor_pk	= array('1', 'EST_EXT');
$li_est_ext 	= $crud->fila_contar('MAE_ESTUDIANTE', $array_campo_pk, $array_valor_pk);	

// Cuenta Estudiantes Internos - Masculino
$array_campo_pk	= array('V_FLAG_ESTADO', 'V_TIPO_EST', 'V_FG_SEXO');
$array_valor_pk	= array('1', 'EST_INT', 'M');
$li_est_int_m 	= $crud->fila_contar('MAE_ESTUDIANTE', $array_campo_pk, $array_valor_pk);

// Cuenta Estudiantes Internos - Femenino
$array_campo_pk	= array('V_FLAG_ESTADO', 'V_TIPO_EST', 'V_FG_SEXO');
$array_valor_pk	= array('1', 'EST_INT', 'F');
$li_est_int_f 	= $crud->fila_contar('MAE_ESTUDIANTE', $array_campo_pk, $array_valor_pk);

// Cuenta Estudiantes Internos - Edades
$li_est_int_edad_01 = $crud->f_get_edadesxcategoria(DEF_EDAD_NIN_MIN, DEF_EDAD_NIN_MAX);
$li_est_int_edad_02 = $crud->f_get_edadesxcategoria(DEF_EDAD_ADO_MIN, DEF_EDAD_ADO_MAX);
$li_est_int_edad_03 = $crud->f_get_edadesxcategoria(DEF_EDAD_JOV_MIN, DEF_EDAD_JOV_MAX);

// Cuenta Usuarios
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('1');
$li_usuarios	= $crud->fila_contar('MAE_USUARIO', $array_campo_pk, $array_valor_pk);	

// Cuenta Tarifas
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('1');
$li_tarifas		= $crud->fila_contar('MAE_TARIFA', $array_campo_pk, $array_valor_pk);	

// Cuenta Horarios
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('2');
$li_horarios	= $crud->fila_contar('MOV_HORARIO', $array_campo_pk, $array_valor_pk);	

// Ùltimo Evento
$li_ult_evento	= $crud->fila_recuperar_lastId('MOV_EVENTO', 'N_COD_EVENTO');	
if ($li_ult_evento > 0) {
	$array_campo_pk	= array('N_COD_EVENTO');
	$array_valor_pk	= array($li_ult_evento);
	$ld_fec_evento 	= $crud->fila_recuperar_campo('MOV_EVENTO', $array_campo_pk, $array_valor_pk,'D_FECHA');	
	$ls_des_evento 	= $crud->fila_recuperar_campo('MOV_EVENTO', $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');	
}else{
	$ld_fec_evento 	= 'NO DISPONIBLE';
	$ls_des_evento	= '';
}

// Lista de Horarios aperturados
$array_campo_pk = ['V_FLAG_ESTADO'];
$array_valor_pk = ['2'];
$array_horarios = $crud->fila_listar(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'D_FEC_INICIO', 'D', 0, 1000);

// Lista de Cinturones KUP
$array_campo_pk = ['V_FLAG_ESTADO', 'N_COD_TIPOGRADO'];
$array_valor_pk = ['1', '1'];
$array_cinturones = $crud->fila_listar(DEF_TABLA_CINTURON, $array_campo_pk, $array_valor_pk, 'N_ORDEN', 'A', 0, 10);

?>
	<!-- Seccion Contenido -->
    <div class="content-wrapper">
		
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Dashboard
			<small>Estadisticas</small>
		  </h1>
		</section>
	
        <!-- Contenido -->
	    <section class="content">	
	
			<!-- Small boxes (Stat box) -->
			<div class="row">

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-aqua">&nbsp;<i class="fa fa-briefcase"></i></span>
						<div class="info-box-content">
						<span class="info-box-text">Sedes</span>
						<span class="info-box-number"><?php echo $li_sedes; ?></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-red">&nbsp;<i class="fa fa-user-secret"></i></span>
						<div class="info-box-content">
						<span class="info-box-text">Instructores</span>
						<span class="info-box-number"><?php echo $li_instructores; ?></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				
				<!-- fix for small devices only -->
				<div class="clearfix visible-sm-block"></div>

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-green">&nbsp;<i class="fa fa-child"></i></span>
						<div class="info-box-content">
						<span class="info-box-text">Estudiantes Interno</span>
						<span class="info-box-number"><?php echo $li_est_int; ?></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-yellow">&nbsp;<i class="ion ion-ios-people-outline"></i></span>
						<div class="info-box-content">
						<span class="info-box-text">Estudiantes Ext.</span>
						<span class="info-box-number"><?php echo $li_est_ext; ?></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

			</div>
			<!-- /.row -->

			<div class="row">
				<div class="col-md-12">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">Clasificación de Cinturones</h3>
						</div>			
            			<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<?php
								$li_cuenta = 0;
								while ($row = mysqli_fetch_assoc($array_cinturones)) {
									$li_cant_cinturon = $crud->f_get_cinturones($row['N_COD_CINTURON']);
									if ($li_est_int == 0) {
										$li_porcentaje = 0;
									} else {
										$li_porcentaje = ($li_cant_cinturon/$li_est_int)*100;
									}
									$li_cuenta = $li_cuenta + 1;
									if ($li_cuenta == 1 OR $li_cuenta == 6) {
										echo "<div class='col-md-4'>";
											if ($li_cuenta == 1) {
												echo "<p class='text-left'>";
													echo "<strong>Grados KUP</strong>";
												echo "</p>";
											}else{	
												echo "<p class='text-left'>";
													echo "&nbsp";
												echo "</p>";
											}
									}
									echo "<div class='progress-group'>";
										echo "<span class='progress-text'>".$row['V_DES_CORTA']."</span>";
										echo "<span class='progress-number'><b>".$li_cant_cinturon."</b>/".$li_est_int."</span>";
										echo "<div class='progress sm'>";
											echo "<div class='progress-bar progress-bar-green' style='width: $li_porcentaje%'></div>";
										echo "</div>";
									echo "</div>";
									if ($li_cuenta == 5 OR $li_cuenta == 10) {
										echo "</div>";
									}
								}									
								?>								

								<div class="col-md-4">

									<p class="text-center">
										<strong>Otros Indicadores</strong>
									</p>

									<div class="progress-group">
										<span class="progress-text">Niños <?php echo '('.DEF_EDAD_NIN_MIN.'-'.DEF_EDAD_NIN_MAX.' años)'; ?></span>
										<span class="progress-number"><b><?php echo $li_est_int_edad_01; ?></b>/<?php echo $li_est_int; ?></span>
										<div class="progress sm">
										<div class="progress-bar progress-bar-aqua" style="width: <?php if($li_est_int == 0){ echo 0; }else{ echo ($li_est_int_edad_01/$li_est_int)*100;} ?>%"></div>
										</div>
									</div>
									<!-- /.progress-group -->
									
									<div class="progress-group">
										<span class="progress-text">Adolescentes <?php echo '('.DEF_EDAD_ADO_MIN.'-'.DEF_EDAD_ADO_MAX.' años)'; ?></span>
										<span class="progress-number"><b><?php echo $li_est_int_edad_02; ?></b>/<?php echo $li_est_int; ?></span>
										<div class="progress sm">
										<div class="progress-bar progress-bar-green" style="width: <?php if($li_est_int == 0){ echo 0; }else{ echo ($li_est_int_edad_02/$li_est_int)*100;} ?>%"></div>
										</div>
									</div>
									<!-- /.progress-group -->

									<div class="progress-group">
										<span class="progress-text">Jóvenes <?php echo '('.DEF_EDAD_JOV_MIN.'-'.DEF_EDAD_JOV_MAX.' años)'; ?></span>
										<span class="progress-number"><b><?php echo $li_est_int_edad_03; ?></b>/<?php echo $li_est_int; ?></span>
										<div class="progress sm">
										<div class="progress-bar progress-bar-blue" style="width: <?php if($li_est_int == 0){ echo 0; }else{ echo ($li_est_int_edad_03/$li_est_int)*100;} ?>%"></div>
										</div>
									</div>
									<!-- /.progress-group -->

									<div class="progress-group">
										<span class="progress-text">Masculino</span>
										<span class="progress-number"><b><?php echo $li_est_int_m; ?></b>/<?php echo $li_est_int; ?></span>
										<div class="progress sm">
										<div class="progress-bar progress-bar-red" style="width: <?php if($li_est_int == 0){ echo 0; }else{ echo ($li_est_int_m/$li_est_int)*100;} ?>%"></div>
										</div>
									</div>
									<!-- /.progress-group -->

									<div class="progress-group">
										<span class="progress-text">Femenino</span>
										<span class="progress-number"><b><?php echo $li_est_int_f; ?></b>/<?php echo $li_est_int; ?></span>
										<div class="progress sm">
										<div class="progress-bar progress-bar-yellow" style="width: <?php if($li_est_int == 0){ echo 0; }else{ echo ($li_est_int_f/$li_est_int)*100;} ?>%"></div>
										</div>
									</div>
									<!-- /.progress-group -->

								</div>
								<!-- /.col -->
								
							</div>
							<!-- /.row -->
			  
						</div>
						<!-- ./box-body -->
           
						<div class="box-footer">
							<div class="row">
								<div class="col-sm-3 col-xs-6">
								<div class="description-block border-right">
									<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
									<h5 class="description-header">$35,210.43</h5>
									<span class="description-text">TOTAL VENTAS</span>
								</div>
								<!-- /.description-block -->
								</div>
								<!-- /.col -->
								<div class="col-sm-3 col-xs-6">
								<div class="description-block border-right">
									<span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
									<h5 class="description-header">$10,390.90</h5>
									<span class="description-text">TOTAL GASTOS</span>
								</div>
								<!-- /.description-block -->
								</div>
								<!-- /.col -->
								<div class="col-sm-3 col-xs-6">
								<div class="description-block border-right">
									<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
									<h5 class="description-header">$24,813.53</h5>
									<span class="description-text">UTILIDADES</span>
								</div>
								<!-- /.description-block -->
								</div>
								<!-- /.col -->
								<div class="col-sm-3 col-xs-6">
								<div class="description-block">
									<span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
									<h5 class="description-header">1200</h5>
									<span class="description-text">METAS</span>
								</div>
								<!-- /.description-block -->
								</div>
							</div>
							<!-- /.row -->
						</div>
						<!-- /.box-footer -->

					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->

			<!-- Main row -->
			<div class="row">

				<!-- Left col -->
				<div class="col-md-8">

					<!-- TABLE: LATEST ORDERS -->
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Lista de Horarios Aperturados</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table class="table no-margin">
									<thead>
										<tr>
											<th>Horario</th>
											<th>Sede</th>
											<th>Instructor</th>
											<th>Fecha Inicio</th>
											<th>Turno</th>
											<th>Hora</th>
										</tr>
									</thead>
									<tbody>
									<?php
										while ($row = mysqli_fetch_assoc($array_horarios)) {
											?>
											<tr>
												<?php
												echo "<td>";
												echo $row["V_DESCRIPCION"];
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
												echo "</td>";
												
											echo "</tr>";
										}
										?>						
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
						</div>
						
					</div>
					<!-- /.box -->

				</div>

				<div class="col-md-4">
					<!-- Info Boxes Style 2 -->
					<div class="info-box bg-yellow">
						<span class="info-box-icon">&nbsp;<i class="fa fa-user-o"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Usuarios</span>
							<span class="info-box-number"><?php echo $li_usuarios; ?></span>

							<div class="progress">
								<div class="progress-bar" style="width: 40%"></div>
							</div>
							<span class="progress-description">
								Accesos al sistema
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->

					<div class="info-box bg-green">
						<span class="info-box-icon">&nbsp;<i class="fa fa-calendar-check-o"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Horarios Aperturados</span>
							<span class="info-box-number"><?php echo $li_horarios; ?></span>
							<div class="progress">
								<div class="progress-bar" style="width: 60%"></div>
							</div>
							<span class="progress-description">
								Disponibles
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->

					<div class="info-box bg-red">
						<span class="info-box-icon">&nbsp;<i class="fa fa-code"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Tarifas</span>
							<span class="info-box-number"><?php echo $li_tarifas; ?></span>
							<div class="progress">
								<div class="progress-bar" style="width: 80%"></div>
							</div>
							<span class="progress-description">
								Tarifario
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->

					<div class="info-box bg-aqua">
						<span class="info-box-icon">&nbsp;<i class="fa fa-calendar"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Último Evento</span>
							<span class="info-box-number"><?php echo $ld_fec_evento; ?></span>
							<div class="progress">
								<div class="progress-bar" style="width: 40%"></div>
							</div>
							<span class="progress-description">
								<?php echo $ls_des_evento; ?>
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->

		  		</div>

			</div>
			<!-- /.row -->

	    </section>
        
    </div>
    <!-- Fin seccion Contenido -->
<?php
}

// Formulario de Registro
function f_form_cambiarclave($as_msgRpta) {

	// Instanciar clase
	$crud = new crud();

	// Enlaces
	$url_actualizar	= "../controlador/mae_cambiarclave_actualizar.php";
	
	// Formulario HTML
	?>

	<!-- Sección Contenido -->
	<div class="content-wrapper">

		<!-- Cabecera de Sección Contenido -->
		<section class="content-header">
			<h1>
				<i class="fa fa-unlock-alt"></i> Cambiar Clave
			</h1>
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
							<i class="fa fa-edit"></i>
							MANTENIMIENTO
						</div>

						<!-- Cuerpo -->
						<div class="panel-body">

							<form  id="form_mtto" role="form" method="post" action="" enctype="multipart/form-data" autocomplete="off">

								<div class="form-group">
									<label for="id_clave_actual">Contraseña Actual </label>
									<input type="password" class="form-control" id="id_clave_actual" name="id_clave_actual" maxlength="20" required
									title = "Tamaño máximo: 20" placeholder="**********" value="">
								</div>
								
								<div class="form-group">
									<label for="id_clave_nueva">Nueva Contraseña </label>
									<input type="password" class="form-control" id="id_clave_nueva" name="id_clave_nueva" maxlength="20" required
									title = "Tamaño máximo: 20" placeholder="**********" value="">
								</div>

								<div class="form-group">
									<label for="id_clave_nueva_confirma">Repetir Nueva Contraseña </label>
									<input type="password" class="form-control" id="id_clave_nueva_confirma" name="id_clave_nueva_confirma" maxlength="20" required
									title = "Tamaño máximo: 20" placeholder="**********" value="">
								</div>

								<input class="btn btn-success" type="submit" id ="btn_actualizar" value="Actualizar Contraseña" onclick=this.form.action="<?php echo $url_actualizar?>">
			
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