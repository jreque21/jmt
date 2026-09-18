<?php
// Incluye Clase BD
require_once("../../BackEnd/config/class_crud.php");
require_once("../../BackEnd/config/funciones.php");
require_once("../../BackEnd/config/global.php");
require_once("Layout/carga.php");
require_once("Layout/pie.php");

/********************************************************/
// Sección Cargando
/********************************************************/
function f_seccion_cargando(){
?>
<div class="preloader">
  <div class="preloader-body">
	<div class="cssload-container">
	  <div class="cssload-speeding-wheel"></div>	  
	  <p>Cargando...</p>
	</div>
  </div>
</div>
<?php
}

/********************************************************/
// Sección Menú
/********************************************************/
function f_seccion_menu($opc){

// Instanciar clase de la B.D
$crud = new crud();

?>
<header class="page-header">
	<!-- RD Navbar-->
	<div class="rd-navbar-wrap">
	  <nav class="rd-navbar rd-navbar_half-dark" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-sm-device-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-device-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-stick-up-clone="false" data-sm-stick-up="true" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true" data-lg-stick-up-offset="69px" data-xl-stick-up-offset="35px" data-xxl-stick-up-offset="35px">
		<div class="rd-navbar-inner">
		  <!-- RD Navbar Panel-->
		  <div class="rd-navbar-panel">
			<button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
		  </div>
		  <!-- RD Navbar Nav-->
		  <div class="rd-navbar-nav-wrap">
			<div class="rd-navbar-nav-wrap__element"></div>
			<ul class="rd-navbar-nav">
			  <?php
			  if ($opc == 'panel'){ echo '<li class="active">'; }else{ echo '<li>';}
			  ?> <a href="panel_intranet.php">Inicio</a> </li>
			  
			  <?php
			  if ($opc == 'horarios'){ echo '<li class="active">'; }else{ echo '<li>';}
			  ?> <a href="horarios.php">Horarios</a> </li>
			  
			  <?php
			  if ($opc == 'promociones'){ echo '<li class="active">';}else{ echo '<li>';}
			  ?> <a href="promociones.php">Promociones</a> </li>  
			  
			  <?php
			  if ($opc == 'eventos'){ echo '<li class="active">';}else{ echo '<li>';}
			  ?> <a href="eventos.php">Eventos</a> </li>
				
			  <?php
			  if ($opc == 'metas'){ echo '<li class="active">'; }else{ echo '<li>';}
			  ?> <a href="metas.php">Mis Metas</a> </li>

			  <?php
			  if ($opc == 'contacto'){ echo '<li class="active">'; }else{ echo '<li>';}
			  ?> <a href="contacto.php">Contáctanos</a> </li>	
			  
			  <?php
			  if ($opc == 'salir'){ echo '<li class="active">'; }else{ echo '<li>';}
			  ?> <a href="salir.php">Salir</a> </li>	

			</ul>
		  </div>
		</div>
	  </nav>
	</div>
</header>
<?php
}

/********************************************************/
// Sección Panel Principal
/********************************************************/
function f_seccion_panel($an_cod_estudiante){

// Instanciar clase de la B.D
$crud = new crud();

// Listado
$array_campo_pk	= array('N_COD_ESTUDIANTE');
$array_valor_pk	= array($an_cod_estudiante);
$arrayPadron    = $crud->fila_recuperar('MAE_ESTUDIANTE', $array_campo_pk, $array_valor_pk);
$li_edad  		= f_get_edad($arrayPadron["D_FEC_NACIMIENTO"]);
$ls_foto		= $arrayPadron["V_FOTO"];

// Género
$ls_fg_sexo =  $arrayPadron["V_FG_SEXO"];
if ($ls_fg_sexo =='M') {
	$ls_des_sexo = 'Masculino';
	$ls_foto_default = 'est_masculino.png';
}
if ($ls_fg_sexo =='F') {
	$ls_des_sexo = 'Femenino';
	$ls_foto_default = 'est_femenino.png';
}	

// Cinturón Actual
$li_cinturon_actual = $crud->f_get_cinturonActual($arrayPadron["N_COD_ESTUDIANTE"]);
$ls_cinturon		= $crud->fila_recuperar_campo('MAE_CINTURON', array('N_COD_CINTURON'), array($li_cinturon_actual), 'V_DES_CORTA');
$ls_cinturon_foto	= $crud->fila_recuperar_campo('MAE_CINTURON', array('N_COD_CINTURON'), array($li_cinturon_actual), 'V_FOTO');

// Tipo Estudiante
$array_campo_pk = ['V_COD_TIPO'];
$array_valor_pk = [$arrayPadron["V_TIPO_EST"]];
$ls_tipoest		= $crud->fila_recuperar_campo('MAE_TIPO_USUARIO', $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');

// Según caso
if ($arrayPadron["V_TIPO_EST"] == 'EST_INT') {
	// Datos Sede
	$array_campo_pk = ['N_COD_SEDE'];
	$array_valor_pk = [$arrayPadron["N_COD_SEDE"]];
	$ls_sede 		= $crud->fila_recuperar_campo(DEF_TABLA_SEDE, $array_campo_pk, $array_valor_pk, 'V_NOMBRE');
	$ls_lugar 		= $ls_sede;

	// Logo: estudiante interno -> logo de la sede
	$t_img_logo		= $crud->fila_recuperar_campo(DEF_TABLA_SEDE, $array_campo_pk, $array_valor_pk, 'V_FOTO');
	$ls_logo_dir	= DEF_UPLOAD_SEDE_DIR;
} else {
	// Datos Academia
	$array_campo_pk = ['N_COD_ACADEMIA'];
	$array_valor_pk = [$arrayPadron["N_COD_ACADEMIA"]];
	$ls_academia	= $crud->fila_recuperar_campo('MAE_ACADEMIA', $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');
	$ls_lugar 		= $ls_academia;

	// Logo: estudiante externo -> logo de la academia
	$t_img_logo		= $crud->fila_recuperar_campo('MAE_ACADEMIA', $array_campo_pk, $array_valor_pk, 'V_LOGO');
	$ls_logo_dir	= DEF_UPLOAD_ACADEMIA_DIR;
}

// Si la sede/academia no tiene logo propio, usar una imagen genérica de taekwondo
if (empty($t_img_logo)) {
	$ls_logo_src = '../../website/recursos/images/t_fondo.jpg';
} else {
	$ls_logo_src = '../../upload/'.$ls_logo_dir.'/'.$t_img_logo;
}

// Contadores
$ldc_deudas = $crud->f_get_datosEstudiante($an_cod_estudiante,'N_DEUDAS');
$ls_prox_fecha = $crud->f_get_datosEstudiante($an_cod_estudiante,'D_PROX_FECHA');
$ls_prox_hora = $crud->f_get_datosEstudiante($an_cod_estudiante,'D_PROX_HORA');
$li_faltas = $crud->f_get_datosEstudiante($an_cod_estudiante,'N_FALTAS');

?>
	<div align = 'center'>
		</br>
		<a class="brand-name" href="panel_intranet.php"><img src="<?php echo $ls_logo_src;?>" alt="" width="140" height="40"/></a>
		</br></br>
	</div>

		<div class="container">
		<div class="row">

			<div class="col-lg-4">

				<div class="panel panel-primary" align = 'center'>
					<div class="panel-heading">F I C H A  &nbsp;&nbsp; T É C N I C A</div>
					<div class="panel-body">
						<?php			
							if(strlen($ls_foto)>1){
							?>	
								<img class="img-rounded" src="../../upload/estudiante/<?php echo $ls_foto;?>" width="155" align ='center'>
							<?php
							}else{
							?>	
								<img class="img-rounded" src="../../upload/estudiante/<?php echo $ls_foto_default;?>" width="155">
							<?php
							}
							echo "</br>";
							echo $arrayPadron ["V_NOMBRES"].', '.$arrayPadron ["V_APE_PATERNO"].' '.$arrayPadron ["V_APE_MATERNO"].'</br>';
							echo $li_edad.' Años - '.$ls_des_sexo.'</br>';							
							?>
							<img class="img-rounded" src="../../upload/cinturon/<?php echo $ls_cinturon_foto;?>" >
							<?php
							echo '</br>Cinturón '.$ls_cinturon.'</br>';
						?>
					</div>
					<div class="panel-footer"><?php echo $ls_lugar; ?></div>
				</div>
	  
			</div>

			<div class="col-lg-4">

				<div class="panel panel-primary" >
					<div class="panel-heading" align = 'center'>I N D I C A D O R E S</div>
					<div class="panel-body">						
						&nbsp;
						<div class="row g-0">
							<div class="col-md-2">
								<span class="fa fa-calendar fa-4x fa-lg"></span>
							</div>
							<div class="col-md-10">							
								<div class ='h_sub'>Próxima Clase <strong>[ <?php echo $ls_prox_fecha; ?> ]</strong></div>
							</div>
						</div>
						
						<div class="row g-0">
							<div class="col-md-2">
								<span class="fa fa-clock-o fa-4x fa-lg"></span>
							</div>
							<div class="col-md-10">
								<div class ='h_sub'>Hora de Clase <strong>[ <?php echo substr($ls_prox_hora,0,5); ?> ]</strong></div>
							</div>
						</div>
						 
						<div class="row g-0">
							<div class="col-md-2">
								<span class="fa fa-check-square-o fa-4x fa-lg"></span>
							</div>
							<div class="col-md-10">
								<div class ='h_sub'>Faltas <strong>[ <?php echo $li_faltas; ?> ]</strong></div>
							</div>
						</div>

						<div class="row g-0">
							<div class="col-md-2">
								<?php if ($ldc_deudas == 0) { ?>
									<span class="fa fa-smile-o fa-4x fa-lg"></span>
								<?php } else { ?>	
									<span class="fa fa-frown-o fa-4x fa-lg"></span>
								<?php } ?>	
							</div>
							<div class="col-md-10">
								<div class ='h_sub'>Deudas <strong>[ <?php echo number_format($ldc_deudas, 2, '.', ' '); ?> ]</strong></div>
								&nbsp;
							</div>
						</div>

					</div>
					<div class="panel-footer" align = 'center'><?php echo $ls_tipoest; ?></div>
				</div>
	  
			</div>
							
			<div class="col-lg-4">

				<div class="panel panel-primary" align = 'center'>
					<div class="panel-heading">S E G U I M I E N T O</div>
					<div class="panel-body">

						</br>

						<a class="btn btn-info" style="width: 100%;" href="datos.php" role="button">
							<span class="fa fa-drivers-license-o"></span> MIS DATOS PERSONALES
						</a>
						</br></br>
						<a class="btn btn-warning" style="width: 100%;" href="cinturones.php" role="button">
							<span class="fa fa-mortar-board"></span> MIS CINTURONES
						</a>
						</br></br>
						<a class="btn btn-success" style="width: 100%;" href="asistencia.php" role="button">
							<span class="fa fa-calendar-check-o"></span> MI ASISTENCIA
						</a>
						</br></br>
						<a class="btn btn-warning" style="width: 100%;" href="pagos.php" role="button">
							<span class="fa fa-cc-visa"></span> MIS PAGOS
						</a>
						</br></br>
						<a class="btn btn-info" style="width: 100%;" href="notas.php" role="button">
							<span class="fa fa-bar-chart-o"></span> MIS AVANCES
						</a>
						</br></br>
						<a class="btn btn-success" style="width: 100%;" href="traslados.php" role="button">
							<span class="fa fa-plane"></span> TRASLADOS
						</a>
						</br></br>

					</div>
					<div class="panel-footer"><a href="mae_cambiarclave.php">Cambiar Clave</a></div>
				</div>
	  
			</div>

		</div>
	</div>

<?php
}

/********************************************************/
// Sección Formulario de Contacto
/********************************************************/
function f_seccion_contacto(){
?>
<section class="bg-gray-lighter object-wrap" id="contacts">
<div class="section-lg">
  <div class="container">
	<div class="row justify-content-end">
	  <div class="col-lg-5">
		<h4 class="heading-decorated">Contáctanos</h4>
		<!-- RD Mailform-->
		<form data-form-type="contact" method="post" action="sendContact.php">
		  <div class="form-wrap">
			<input class="form-input" id="contact-name" type="text" name="nombre" data-constraints="@Required">
			<label class="form-label" for="contact-name">Tu nombre</label>
		  </div>
		  <div class="form-wrap">
			<input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Email @Required">
			<label class="form-label" for="contact-email">Tu Email</label>
		  </div>
		  <div class="form-wrap">
			<textarea class="form-input" id="contact-message" name="mensaje" data-constraints="@Required"></textarea>
			<label class="form-label" for="contact-message">Tu mensaje</label>
		  </div>
		  <button class="button button-primary" type="submit">Enviar</button>
		</form>
	  </div>
	</div>
  </div>
</div>
<div class="object-wrap__body object-wrap__body-sizing-1 object-wrap__body-md-left bg-image" style="background-image: url(../images/fondo_contacto.jpg)"></div>
</section>
<?php
}

/********************************************************/
// Sección Horarios
/********************************************************/
function f_seccion_horarios(){

// Urls
$url_det = 'horario_det.php';

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('2');

// Listado
$array = $crud->fila_listar(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'D_FEC_INICIO', 'D', 0, 10);
	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_horarios.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Horarios Disponibles</h4>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Horario</th>
										<th>Sede</th>
										<th>Instructor</th>
										<th>Fecha Inicio</th>
										<th>Turno</th>
										<th>Hora</th>
										<th>Categoría</th>
										<th>Estado</th>
										<th>Detalle</th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($array)) {
										$url_det_fila    = $url_det."?id_codigo=".($row["N_COD_HORARIO"]);
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
											<a href="<?php echo $url_det_fila?>">
												<i class="fa fa-list" title = "Ver Matriculados"></i>
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
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Horarios - Detalle
/********************************************************/
function f_seccion_horario_det($an_id_codigo_padre){

// Url
$url_lista		= "horarios.php";

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('N_COD_HORARIO');
$array_valor_pk	= array($an_id_codigo_padre);

// Listado
$array = $crud->fila_listar(DEF_TABLA_MATRICULA, $array_campo_pk, $array_valor_pk, 'D_FEC_INICIO', 'D', 0, 10);

// Datos Padre
$ls_subtitulo	= $crud->fila_recuperar_campo(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');

?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_horarios.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Horario <?php echo $ls_subtitulo; ?> [ Matriculados ]</h4>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Nº</th>
										<th>Estudiante</th>
										<th>Edad</th>
										<th>Género</th>
										<th>Cinturón</th>
										<th>Fecha Matrícula</th>
									</tr>
								</thead>

								<tbody>
									<?php
									$li_contador = 0;
									while ($row = mysqli_fetch_assoc($array)) {
										$li_contador = $li_contador + 1;
										?>
										<tr>
											<?php
											echo "<td>";
											echo $li_contador;
											echo "</td>";

											// Datos Estudiante
											$array_campo_pk	= array('N_COD_ESTUDIANTE');
											$array_valor_pk	= array($row["N_COD_ESTUDIANTE"]);
											$arrayPadron   = $crud->fila_recuperar(DEF_TABLA_ESTUDIANTE, $array_campo_pk, $array_valor_pk);
											echo "<td>";
											echo $arrayPadron['V_APE_PATERNO'].' '.$arrayPadron['V_APE_MATERNO'].' '.$arrayPadron['V_NOMBRES'];
											echo "</td>";

											echo "<td>";
											echo f_get_edad($arrayPadron["D_FEC_NACIMIENTO"]);
											echo "</td>";

											echo "<td>";
												$ls_fg_sexo =  $arrayPadron["V_FG_SEXO"];
												if ($ls_fg_sexo =='M') $ls_des_sexo = 'Masculino';
												if ($ls_fg_sexo =='F') $ls_des_sexo = 'Femenino';
												echo $ls_des_sexo;
											echo "</td>";

											// Cinturón Actual
											$li_cinturon_actual = $crud->f_get_cinturonActual($row["N_COD_ESTUDIANTE"]);
											$array_campo_pk	= array('N_COD_CINTURON');
											$array_valor_pk	= array($li_cinturon_actual);
											$ls_cinturon	= $crud->fila_recuperar_campo(DEF_TABLA_CINTURON, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
											echo "<td>";
											echo $ls_cinturon;
											echo "</td>";
											
											echo "<td>";
											echo $row["D_FEC_MATRICULA"];
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
				<a class="btn btn-primary" href="<?php echo $url_lista?>" role="button">
					<span class="fa fa-mail-reply"></span>&nbsp;&nbsp;Regresar
				</a>				
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Promociones
/********************************************************/
function f_seccion_promociones(){

// Urls
$url_det = 'promocion_det.php';

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('1');

// Listado
$array = $crud->fila_listar(DEF_TABLA_PROMOCION, $array_campo_pk, $array_valor_pk, 'D_FEC_PROG', 'D', 0, 10);
	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_promociones.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Promociones</h4>
				<!-- Cuerpo -->
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

								<thead class="thead-dark">
									<tr>
										<th>Descripción</th>
										<th>Lugar</th>
										<th>Fecha Programada</th>
										<th>Costo</th>
										<th>Sede</th>
										<th>Nº de Promocionados</th>
										<th>Estado</th>
										<th>Detalle</th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($array)) {
										$url_det_fila    = $url_det."?id_codigo=".($row["N_COD_PROMOCION"]);
										?>
										<tr>
											<?php
											echo "<td>";
											echo $row["V_DESCRIPCION"];
											echo "</td>";

											echo "<td>";
											echo $row["V_LUGAR"];
											echo "</td>";

											echo "<td>";
											echo $row["D_FEC_PROG"];
											echo "</td>";

											echo "<td>";
											echo $row["N_MONTO"];
											echo "</td>";

											// Sede
											$array_campo_pk	= array('N_COD_SEDE');
											$array_valor_pk	= array($row["N_COD_SEDE"]);
											$ls_sede		= $crud->fila_recuperar_campo(DEF_TABLA_SEDE, $array_campo_pk, $array_valor_pk, 'V_NOMBRE');
											echo "<td>";
											echo $ls_sede;
											echo "</td>";

											echo "<td>";
												// Cantidad 
												$array_campo_pk	= array('N_COD_PROMOCION', 'V_FLAG_PROG');
												$array_valor_pk	= array($row["N_COD_PROMOCION"], '1');
												$li_cantidad	= $crud->fila_contar(DEF_TABLA_PROMOCIONPROG, $array_campo_pk, $array_valor_pk);
												echo $li_cantidad;
											echo "</td>";

											echo "<td>";
												$ls_estado =  $row["V_FLAG_ESTADO"];
												if ($ls_estado =='0') $estado = 'Inactivo';
												if ($ls_estado =='1') $estado = 'Activo';
												echo $estado;
											echo "</td>";

											echo "<td align='center'>";
											?>
											<a href="<?php echo $url_det_fila?>">
												<i class="fa fa-list" title = "Ver promocionados"></i>
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
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Promociones - Detalle
/********************************************************/
function f_seccion_promocion_det($an_id_codigo_padre){

// Url
$url_lista		= "promociones.php";

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('N_COD_PROMOCION', 'N_COD_ESTUDIANTE');
$array_valor_pk	= array($an_id_codigo_padre, $_SESSION['N_COD_REFERENCIA']);

// Datos Padre
$ls_hora	= $crud->fila_recuperar_campo(DEF_TABLA_PROMOCIONPROG, $array_campo_pk, $array_valor_pk, 'D_HORA_PROG');

// Definir estructura
$array_campo_pk	= array('N_COD_PROMOCION', 'D_HORA_PROG');
$array_valor_pk	= array($an_id_codigo_padre, $ls_hora);

// Listado
$array = $crud->fila_listar(DEF_TABLA_PROMOCIONPROG, $array_campo_pk, $array_valor_pk, 'D_HORA_PROG', 'A', 0, 9999);

// Datos Padre
$array_campo_pk	= array('N_COD_PROMOCION');
$array_valor_pk	= array($an_id_codigo_padre);
$ls_subtitulo	= $crud->fila_recuperar_campo(DEF_TABLA_PROMOCION, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');

?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_promociones.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">PROMOCIÓN <?php echo $ls_subtitulo; ?> [ Lista ]</h4>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Nº</th>
										<th>Estudiante</th>
										<th>Edad</th>
										<th>Genero</th>
										<th>Cinturón Actual</th>
										<th>Cinturón Promoción</th>
										<th>Fecha Programada</th>
										<th>Hora Programada</th>
									</tr>
								</thead>

								<tbody>
									<?php
									$li_contador = 0;
									while ($row = mysqli_fetch_assoc($array)) {
										$li_contador = $li_contador + 1;
										?>
										<tr>
											<?php
											
											// Cinturon
											$array_campo_pk	= array('N_COD_ESTUDIANTE');
											$array_valor_pk	= array($row["N_COD_ESTUDIANTE"]);
											$rowPadron		= $crud->fila_recuperar(DEF_TABLA_ESTUDIANTE, $array_campo_pk, $array_valor_pk);
											?>
											<tr>
												<?php

												echo "<td>";
												echo $li_contador;
												echo "</td>";

												echo "<td>";
												echo $rowPadron["V_APE_PATERNO"].' '.$rowPadron["V_APE_MATERNO"].' '.$rowPadron["V_NOMBRES"];
												echo "</td>";

												echo "<td>";
												echo f_get_edad($rowPadron["D_FEC_NACIMIENTO"]);
												echo "</td>";

												echo "<td>";
													$ls_fg_sexo =  $rowPadron["V_FG_SEXO"];
													if ($ls_fg_sexo =='M') $ls_des_sexo = 'Masculino';
													if ($ls_fg_sexo =='F') $ls_des_sexo = 'Femenino';
													echo $ls_des_sexo;
												echo "</td>";

												// Cinturon Actual
												$array_campo_pk	= array('N_COD_CINTURON');
												$array_valor_pk	= array($row["N_COD_CINTURON_ACTUAL"]);
												$ls_cinturon	= $crud->fila_recuperar_campo(DEF_TABLA_CINTURON, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
												echo "<td>";
												echo $ls_cinturon;
												echo "</td>";

												// Cinturon Nuevo
												$array_campo_pk	= array('N_COD_CINTURON');
												$array_valor_pk	= array($row["N_COD_CINTURON_NUEVO"]);
												$ls_cinturon	= $crud->fila_recuperar_campo(DEF_TABLA_CINTURON, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
												echo "<td>";
												echo $ls_cinturon;
												echo "</td>";

												echo "<td>";
												echo $row["D_FEC_PROG"];
												echo "</td>";

												echo "<td>";
												echo substr($row["D_HORA_PROG"],0,5);
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
				<a class="btn btn-primary" href="<?php echo $url_lista?>" role="button">
					<span class="fa fa-mail-reply"></span>&nbsp;&nbsp;Regresar
				</a>					
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Eventos
/********************************************************/
function f_seccion_eventos(){

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('1');

// Listado
$array = $crud->fila_listar(DEF_TABLA_EVENTO, $array_campo_pk, $array_valor_pk, 'D_FECHA', 'D', 0, 10);
	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_eventos.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Últimos Eventos</h4>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Nombre de Evento</th>
										<th>Lugar</th>
										<th>Fecha</th>
										<th>Hora</th>
										<th>Nº Invitados</th>
										<th>Estado</th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($array)) {
										?>
										<tr>
											<?php
											echo "<td>";
											echo $row["V_DESCRIPCION"];
											echo "</td>";

											echo "<td>";
											echo $row["V_LUGAR"];
											echo "</td>";

											echo "<td>";
											echo $row["D_FECHA"];
											echo "</td>";

											echo "<td>";
											echo substr($row["D_HORA"],0,5);
											echo "</td>";

											echo "<td>";
												// Cantidad 
												$array_campo_pk	= array('N_COD_EVENTO', 'V_FLAG_PROG');
												$array_valor_pk	= array($row["N_COD_EVENTO"], '1');
												$li_cantidad	= $crud->fila_contar(DEF_TABLA_EVENTOPROG, $array_campo_pk, $array_valor_pk);
												echo $li_cantidad;
											echo "</td>";

											echo "<td>";
												$ls_estado =  $row["V_FLAG_ESTADO"];
												if ($ls_estado =='0') $estado = 'Inactivo';
												if ($ls_estado =='1') $estado = 'Activo';
												echo $estado;
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
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Metas
/********************************************************/
function f_seccion_metas(){

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('V_FLAG_ESTADO');
$array_valor_pk	= array('1');

// Listado
$array = $crud->fila_listar(DEF_TABLA_CINTURON, $array_campo_pk, $array_valor_pk, 'N_ORDEN', 'A', 0, 999);
	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_metas.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Nuestro Objetivo</h4>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Orden</th>
										<th>Cinturón</th>
										<th>Imagen</th>
										<th>Tipo de Grado</th>
										<th>Estado</th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($array)) {
										?>
										<tr>
											<?php

											echo "<td>";
											echo $row["N_ORDEN"];
											echo "</td>";

											echo "<td>";
											echo $row["V_DES_CORTA"];
											echo "</td>";

											echo "<td>";
											?>														
											<img class="img-rounded" src="../../upload/<?php echo DEF_UPLOAD_CINTURON_DIR.'/'.$row["V_FOTO"];?>">
											<?php													
											echo "</td>";

											// Tipo Grado
											$array_campo_pk	= array('N_COD_TIPOGRADO');
											$array_valor_pk	= array($row["N_COD_TIPOGRADO"]);
											$ls_tipogrado	= $crud->fila_recuperar_campo('MAE_TIPO_GRADO', $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');

											echo "<td>";
											echo $ls_tipogrado;
											echo "</td>";

											echo "<td>";
												$ls_estado =  $row["V_FLAG_ESTADO"];
												if ($ls_estado =='0') $estado = 'Inactivo';
												if ($ls_estado =='1') $estado = 'Activo';
												echo $estado;
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
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Mis Cinturones
/********************************************************/
function f_seccion_mis_cinturones($an_cod_estudiante){

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('N_COD_ESTUDIANTE', 'V_FLAG_ESTADO');
$array_valor_pk	= array($an_cod_estudiante, '1');

// Listado
$array = $crud->fila_listar('MAE_ESTUDIANTE_CINTURON', $array_campo_pk, $array_valor_pk, 'N_ORDEN', 'A', 0, 99);
	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_cinturones.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Mis Cinturones</h4>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Orden</th>
										<th>Cinturón</th>
										<th>Imagen</th>
										<th>Tipo de Grado</th>
										<th>Fecha</th>
										<th>Estado</th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($array)) {
										?>
										<tr>
											<?php

											echo "<td>";
											echo $row["N_ORDEN"];
											echo "</td>";

											// Array Cinturon
											$array_campo_pk	= array('N_COD_CINTURON');
											$array_valor_pk	= array($row["N_COD_CINTURON"]);
											$arrayCinturon	= $crud->fila_recuperar('MAE_CINTURON', $array_campo_pk, $array_valor_pk);

											echo "<td>";
											echo $arrayCinturon["V_DES_CORTA"];
											echo "</td>";

											echo "<td>";
											?>														
											<img class="img-rounded" src="../../upload/<?php echo DEF_UPLOAD_CINTURON_DIR.'/'.$arrayCinturon["V_FOTO"];?>">
											<?php													
											echo "</td>";

											// Tipo Grado
											$array_campo_pk	= array('N_COD_TIPOGRADO');
											$array_valor_pk	= array($arrayCinturon["N_COD_TIPOGRADO"]);
											$ls_tipogrado	= $crud->fila_recuperar_campo('MAE_TIPO_GRADO', $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');

											echo "<td>";
											echo $ls_tipogrado;
											echo "</td>";

											echo "<td>";
											echo SUBSTR($row["D_AUD_FEC_REG"],0,10);
											echo "</td>";

											echo "<td>";
												$ls_estado =  $row["V_FLAG_ESTADO"];
												if ($ls_estado =='0') $estado = 'Inactivo';
												if ($ls_estado =='1') $estado = 'Activo';
												echo $estado;
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
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Asistencia
/********************************************************/
function f_seccion_asistencia($an_cod_estudiante){

// Urls
$url_det = 'asistencia_det.php';

// Instanciar clase de la B.D
$crud = new crud();

// Listado
$array = $crud->fila_recuperar_horariosxEst($an_cod_estudiante);
	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_asistencia.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Asistencia</h4>
				<p>Selecciona uno de los horarios : </p>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Horario</th>
										<th>Sede</th>
										<th>Instructor</th>
										<th>Fecha Inicio</th>
										<th>Turno</th>
										<th>Hora</th>
										<th>Categoría</th>
										<th>Estado</th>
										<th>Detalle</th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($array)) {
										$url_det_fila    = $url_det."?id_codigo=".($row["N_COD_HORARIO"]);
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
											<a href="<?php echo $url_det_fila?>">
												<i class="fa fa-list" title = "Ver Asistencia"></i>
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
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Asistencia - Detalle
/********************************************************/
function f_seccion_asistencia_det($an_cod_estudiante, $an_id_codigo_padre){

// Url
$url_lista		= "asistencia.php";

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('N_COD_ESTUDIANTE', 'N_COD_HORARIO');
$array_valor_pk	= array($an_cod_estudiante, $an_id_codigo_padre);

// Listado
$array = $crud->fila_listar('MOV_ASISTENCIA', $array_campo_pk, $array_valor_pk, 'N_CLASE', 'A', 0, 99);
$array_lenght = $array->num_rows;

// Datos Padre
$array_campo_pk	= array('N_COD_HORARIO');
$array_valor_pk	= array($an_id_codigo_padre);
$ls_subtitulo	= $crud->fila_recuperar_campo(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');

?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_asistencia.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Asistencia</h4>
				<p>Horario Seleccionado : <?php echo $ls_subtitulo; ?></p>
				<!-- Cuerpo -->
				<?php
					if ($array_lenght == 0 ) { 
						?>
						<div class="alert alert-warning">
							<?php echo DEF_MSG_SIN_REGISTROS;?>
						</div>
						<?php
					}else {
						?>
						<div class="table-responsive">

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Nº Clase</th>
										<th>Fecha</th>
										<th>Día</th>
										<th>Hora Clase</th>
										<th>Instructor</th>
										<th>Asistencia</th>
										<th>Situación</th>
									</tr>
								</thead>

								<tbody>
									<?php
									$li_contador = 0;
									while ($row = mysqli_fetch_assoc($array)) {
										$li_contador = $li_contador + 1;
										?>
										<tr>
											<?php

											// Padrón de Clase
											$array_campo_pk	= array('N_COD_HORARIO', 'N_CLASE');
											$array_valor_pk	= array($row["N_COD_HORARIO"], $row["N_CLASE"]);
											$arrayClase		= $crud->fila_recuperar(DEF_TABLA_HORARIOPROG, $array_campo_pk, $array_valor_pk);

											echo "<td>";
											echo $li_contador;
											echo "</td>";

											echo "<td>";
											echo $arrayClase["D_FEC_PROG"];
											echo "</td>";

											echo "<td>";
											echo f_r_diasemana($arrayClase["D_FEC_PROG"]);
											echo "</td>";

											echo "<td>";
											echo substr($arrayClase["D_HORA_PROG"],0,5);
											echo "</td>";

											// Instructor
											$array_campo_pk	= array('N_COD_INSTRUCTOR');
											$array_valor_pk	= array($row["N_COD_INSTRUCTOR"]);
											$array_instructor	= $crud->fila_recuperar(DEF_TABLA_INSTRUCTOR, $array_campo_pk, $array_valor_pk);
											echo "<td>";
											echo $array_instructor['V_APE_PATERNO'].' '.$array_instructor['V_APE_MATERNO'].' '.$array_instructor['V_NOMBRES'];
											echo "</td>";

											// Almacenar Asistencia
											if( $row["V_FLAG_ESTADO"] == '1'){
												$ls_estado_asistencia = 'Asistió';
											}elseif ($row["V_FLAG_ESTADO"] == '-1') {
												$ls_estado_asistencia = 'No Asistió';
											}else{
												$ls_estado_asistencia = 'Pendiente';
											}
											echo "<td>";
											echo $ls_estado_asistencia;
											echo "</td>";

											// Recuperando datos para combo
											$array_campo_pk	= array('N_COD_TIPOASIST');
											$array_valor_pk	= array($row["N_COD_TIPOASIST"]);
											$ls_tipo_asist  = $crud->fila_recuperar_campo(DEF_TABLA_TIPOASIS, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
											echo "<td>";
											echo $ls_tipo_asist;
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
				<a class="btn btn-primary" href="<?php echo $url_lista?>" role="button">
					<span class="fa fa-mail-reply"></span>&nbsp;&nbsp;Regresar
				</a>
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Pagos
/********************************************************/
function f_seccion_pagos($an_cod_estudiante){

// Urls
$url_det = 'pagos_det.php';

// Instanciar clase de la B.D
$crud = new crud();

// Listado
$array = $crud->fila_recuperar_matriculaxEst($an_cod_estudiante);
	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_pagos.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Pagos</h4>
				<p>Selecciona uno de los horarios : </p>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Matrícula</th>
										<th>Fecha Inicio</th>
										<th>Hora</th>
										<th>Tarifa</th>
										<th>Descuento</th>
										<th>Neto</th>
										<th>Forma Pago</th>
										<th>Pago</th>
										<th>Cuotas</th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($array)) {
										$url_det_fila    = $url_det."?id_codigo=".($row["N_COD_MATRICULA"]);
										?>
										<tr>
											<?php

											// Horario
											$array_campo_pk	= array('N_COD_HORARIO');
											$array_valor_pk	= array($row['N_COD_HORARIO']);
											$array_horario 	= $crud->fila_recuperar(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk);

											echo "<td>";
											echo $array_horario["V_DESCRIPCION"];
											echo "</td>";

											echo "<td>";
											echo $array_horario["D_FEC_INICIO"];
											echo "</td>";

											echo "<td>";
											echo substr($array_horario["D_HORA_INICIO"],0,5);
											echo "</td>";
											
											echo "<td>";
											echo $row["N_MONTO_TARIFA"];
											echo "</td>";

											echo "<td>";
											echo $row["N_MONTO_DSCTO"];
											echo "</td>";

											echo "<td>";
											echo $row["N_MONTO_NETO"];
											echo "</td>";

											// Forma de Pago
											$array_campo_pk	= array('N_COD_FORMAPAGO');
											$array_valor_pk	= array($row["N_COD_FORMAPAGO"]);
											$ls_formapago	= $crud->fila_recuperar_campo(DEF_TABLA_FORMAPAGO, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');

											echo "<td>";
											echo $ls_formapago;
											echo "</td>";

											// Saldo Pendiente
											$li_monto_pendiente	= $crud->f_get_saldoPendiente($row["N_COD_MATRICULA"]);
											echo "<td>";
											echo number_format($li_monto_pendiente, 2, '.', ' ');
											echo "</td>";

											echo "<td align='center'>";
											?>
											<a href="<?php echo $url_det_fila?>">
												<i class="fa fa-list" title = "Ver Pagos"></i>
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
			</div>

		</div>
	</div>
</section>
<?php
}
	
/********************************************************/
// Sección Pagos - Detalle
/********************************************************/
function f_seccion_pagos_det($an_id_codigo_padre){

// Url
$url_lista		= "pagos.php";

// Instanciar clase de la B.D
$crud = new crud();

// Armar Estructura
$array_campo_pk = ['N_COD_MATRICULA'];
$array_valor_pk = [$an_id_codigo_padre];

// Listado
$array = $crud->fila_listar(DEF_TABLA_PAGO, $array_campo_pk, $array_valor_pk, 'N_ITEM', 'A', 0, 1000);
$array_lenght = $array->num_rows;

// Horario ID
$li_horario	= $crud->fila_recuperar_campo(DEF_TABLA_MATRICULA, $array_campo_pk, $array_valor_pk, 'N_COD_HORARIO');

// Datos Padre
$array_campo_pk	= array('N_COD_HORARIO');
$array_valor_pk	= array($li_horario);
$ls_subtitulo	= $crud->fila_recuperar_campo(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');

?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_pagos.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Pagos</h4>
				<p>Horario Seleccionado : <?php echo $ls_subtitulo; ?></p>
				<!-- Cuerpo -->
				<?php
					if ($array_lenght == 0 ) { 
						?>
						<div class="alert alert-warning">
							<?php echo DEF_MSG_SIN_REGISTROS;?>
						</div>
						<?php
					}else {
						?>
						<div class="table-responsive">

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Nº Item</th>
										<th>Fecha Pago</th>
										<th>Moneda</th>
										<th>Monto</th>
										<th>Medio Pago</th>	
									</tr>
								</thead>

								<tbody>
									<?php
									$li_contador = 0;
									while ($row = mysqli_fetch_assoc($array)) {
										$li_contador = $li_contador + 1;
										?>
										<tr>
											<?php

											echo "<td>";
											echo $row["N_ITEM"];
											echo "</td>";

											echo "<td>";
											echo $row["D_FEC_PAGO"];
											echo "</td>";

											// Moneda
											$array_campo_pk	= array('N_COD_MONEDA');
											$array_valor_pk	= array($row["N_COD_MONEDA"]);
											$ls_moneda		= $crud->fila_recuperar_campo(DEF_TABLA_MONEDA, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');

											// Moneda
											$array_campo_pk	= array('N_COD_MEDIOPAGO');
											$array_valor_pk	= array($row["N_COD_MEDIOPAGO"]);
											$ls_mediopago	= $crud->fila_recuperar_campo(DEF_TABLA_MEDIOPAGO, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');

											echo "<td>";
											echo $ls_moneda;
											echo "</td>";

											echo "<td>";
											echo $row["N_MONTO"];
											echo "</td>";

											echo "<td>";
											echo $ls_mediopago;
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
				<a class="btn btn-primary" href="<?php echo $url_lista?>" role="button">
					<span class="fa fa-mail-reply"></span>&nbsp;&nbsp;Regresar
				</a>
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Notas
/********************************************************/
function f_seccion_notas($an_cod_estudiante){

// Urls
$url_det = 'notas_det.php';

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('V_FLAG_ESTADO', 'N_COD_ESTUDIANTE');
$array_valor_pk	= array('1', $an_cod_estudiante);

// Listado
$array = $crud->fila_listar(DEF_TABLA_EVALUACION, $array_campo_pk, $array_valor_pk, 'D_FECHA', 'D', 0, 99999);

	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_notas.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Mis Avances</h4>
				<p>Disponible todas las notas evaluadas : </p>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Fecha</th>
										<th>Nota</th>
										<th>Evaluación</th>
										<th>Horario</th>
										<th>Detalle</th>
									</tr>
								</thead>

								<tbody>
									<?php
									while ($row = mysqli_fetch_assoc($array)) {
										$url_det_fila    = $url_det."?id_codigo=".($row["N_COD_EVALUACION"]);
										?>
										<tr>
											<?php

											echo "<td>";
											echo $row["D_FECHA"];
											echo "</td>";

											echo "<td>";
											echo $row["N_NOTA"];
											echo "</td>";
											
											// Exámen
											$array_campo_pk	= array('N_COD_EXAMEN');
											$array_valor_pk	= array($row['N_COD_EXAMEN']);
											$ls_examen 	    = $crud->fila_recuperar_campo(DEF_TABLA_EXAMEN, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');

											echo "<td>";
											echo $ls_examen;
											echo "</td>";

											// Horario
											$array_campo_pk	= array('N_COD_HORARIO');
											$array_valor_pk	= array($row['N_COD_HORARIO']);
											$ls_horario		= $crud->fila_recuperar_campo(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');

											echo "<td>";
											echo $ls_horario;
											echo "</td>";

											echo "<td align='center'>";
											?>
											<a href="<?php echo $url_det_fila?>">
												<i class="fa fa-list" title = "Ver Detalle"></i>
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
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Notas - Detalle
/********************************************************/
function f_seccion_notas_det($an_id_codigo_padre){

// Url
$url_lista		= "notas.php";

// Instanciar clase de la B.D
$crud = new crud();

// Armar Estructura
$array_campo_pk = ['N_COD_EVALUACION'];
$array_valor_pk = [$an_id_codigo_padre];

// Listado
$array = $crud->fila_listar(DEF_TABLA_EVALUACIONDET, $array_campo_pk, $array_valor_pk, 'N_ITEM', 'A', 0, 1000);
$array_lenght = $array->num_rows;

// Horario ID
$li_horario	= $crud->fila_recuperar_campo(DEF_TABLA_EVALUACION, $array_campo_pk, $array_valor_pk, 'N_COD_HORARIO');

// Datos Padre
$array_campo_pk	= array('N_COD_HORARIO');
$array_valor_pk	= array($li_horario);
$ls_subtitulo	= $crud->fila_recuperar_campo(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION');

?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_notas.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Mis Avances</h4>
				<p>Horario Seleccionado : <?php echo $ls_subtitulo; ?></p>
				<!-- Cuerpo -->
				<?php
					if ($array_lenght == 0 ) { 
						?>
						<div class="alert alert-warning">
							<?php echo DEF_MSG_SIN_REGISTROS;?>
						</div>
						<?php
					}else {
						?>
						<div class="table-responsive">

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>Nº Item</th>
										<th>Competencia Evaluada</th>
										<th>Consideraciones</th>
										<th>Peso</th>
										<th>Nota</th>
										<th>Diagnóstico</th>
									</tr>
								</thead>

								<tbody>
									<?php
									$li_contador = 0;
									while ($row = mysqli_fetch_assoc($array)) {
										$li_contador = $li_contador + 1;
										?>
										<tr>
											<?php

											echo "<td>";
											echo $row["N_ITEM"];
											echo "</td>";

											echo "<td>";
											echo $row["V_DESCRIPCION"];
											echo "</td>";
                                            
                                            // Datos Padre
                                            $array_campo_pk	= array('N_COD_EXAMEN', 'N_ITEM');
                                            $array_valor_pk	= array($row["N_COD_EXAMEN"], $row["N_ITEM"]);
                                            $ls_consideracion	= $crud->fila_recuperar_campo('MAE_EXAMEN_DET', $array_campo_pk, $array_valor_pk, 'V_OBSERVACION');
                                            
                                            echo "<td>";
											echo $ls_consideracion;
											echo "</td>";
											
											echo "<td>";
											echo $row["N_PESO"];
											echo "</td>";

											echo "<td>";
											echo $row["N_NOTA"];
											echo "</td>";
                                            
                                            echo "<td>";
											echo $row["V_OBSERVACION"];
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
				<a class="btn btn-primary" href="<?php echo $url_lista?>" role="button">
					<span class="fa fa-mail-reply"></span>&nbsp;&nbsp;Regresar
				</a>
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Mis Traslados
/********************************************************/
function f_seccion_mis_traslados($an_cod_estudiante){

// Instanciar clase de la B.D
$crud = new crud();

// Definir estructura
$array_campo_pk	= array('N_COD_ESTUDIANTE', 'V_FLAG_ESTADO');
$array_valor_pk	= array($an_cod_estudiante, '1');

// Listado
$array = $crud->fila_listar('MAE_ESTUDIANTE_SEDE', $array_campo_pk, $array_valor_pk, 'D_FEC_INICIO', 'A', 0, 9999);
	
?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_cinturones.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Mis Traslados</h4>
				<!-- Cuerpo -->
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

							<table id="listax" class="table table-striped table-bordered table-hover">

								<thead class="thead-dark">
									<tr>
										<th>N°</th>
										<th>Fecha Inicio</th>
										<th>Fecha Fin</th>
										<th>Sede Origen</th>
										<th>Sede Destino</th>
									</tr>
								</thead>

								<tbody>
									<?php
									$li_x = 0;
									while ($row = mysqli_fetch_assoc($array)) {
									    $li_x = $li_x + 1;
										?>
										<tr>
											<?php

											echo "<td>";
											echo $li_x;
											echo "</td>";

											echo "<td>";
											echo SUBSTR($row["D_FEC_INICIO"],0,10);
											echo "</td>";
											
											echo "<td>";
											echo SUBSTR($row["D_FEC_FIN"],0,10);
											echo "</td>";

											// Sede Origen
											$array_campo_pk	= array('N_COD_SEDE');
											$array_valor_pk	= array($row["N_COD_SEDE_ORIGEN"]);
											$ls_sede_origen	= $crud->fila_recuperar_campo('MAE_SEDE', $array_campo_pk, $array_valor_pk, 'V_NOMBRE');

											echo "<td>";
											echo $ls_sede_origen;
											echo "</td>";
                                            
                                            // Sede Destino
											$array_campo_pk	= array('N_COD_SEDE');
											$array_valor_pk	= array($row["N_COD_SEDE_DESTINO"]);
											$ls_sede_destino= $crud->fila_recuperar_campo('MAE_SEDE', $array_campo_pk, $array_valor_pk, 'V_NOMBRE');

											echo "<td>";
											echo $ls_sede_destino;
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
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Datos
/********************************************************/
function f_seccion_datos($an_cod_estudiante){

// Urls
$url_reporte	= "../../Backend/vista/Report/rpt_estudiante_det.php?id_codigo=".$an_cod_estudiante;

// Instanciar clase de la B.D
$crud = new crud();

// Listado
$array_campo_pk	= array('N_COD_ESTUDIANTE');
$array_valor_pk	= array($an_cod_estudiante);
$array = $crud->fila_recuperar(DEF_TABLA_ESTUDIANTE, $array_campo_pk, $array_valor_pk);

// Inicalizando variables
$lb_edit = is_array($array);
$inhabilitado = "disabled='disabled'";

?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">

			<div class="col-md-11 col-lg-12">
				<h4 class="heading-decorated">Mis Datos Personales</h4>
				<!-- Cuerpo -->
				<?php
					if (!($array)) {
						?>
						<div class="alert alert-warning">
							<?php echo DEF_MSG_SIN_REGISTROS;?>
						</div>
						<?php
					}else {
						?>
						</br>
						<!-- Panel -->
						<div class="panel panel-primary">

							<!-- Cuerpo -->
							<div class="panel-body">
								<!-- Filtro -->
								<form action="" id="form_mtto" method="post" class="d-flex align-self-center">
									<div class="row">
										
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_codigo">Código</label>
												<input type="text" class="form-control" id="id_codigo" name="id_codigo" maxlength="5" disabled
													title = "Generado por el sistema" placeholder="Codigo autogenerado" value="<?php echo $lb_edit?$array["N_COD_ESTUDIANTE"]:""; ?>">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_fec_alta">Fecha de Ingreso</label>
												<input type="date" class="form-control input-sm" id="id_fec_alta" name="id_fec_alta" autofocus required disabled"
													title = "Formato Fecha" value="<?php echo $lb_edit?$array["D_FEC_ALTA"]:""; ?>"> 
											</div>										
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_tipo_est">Tipo de Estudiante</label>
												<input type="text" class="form-control" id="id_tipo_est" name="id_tipo_est" maxlength="150" disabled
													title = "Letras. Tamaño máximo: 150" value="INTERNO"> 
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_tipo_doc">Tipo de Documento</label>
												<select class="form-control" id="id_tipo_doc" name="id_tipo_doc" required disabled>
													<?php
													
													// Recuperando datos para combo
													$array_campo_pk	= array('V_FLAG_ESTADO');
													$array_valor_pk	= array('1');
													$array_tipo     = $crud->fila_listar(DEF_TABLA_TIPO_DOC, $array_campo_pk, $array_valor_pk, 'N_COD_TIPODOC', 'A', 0, 100);

													// Mostrando combo
													echo "<option value='' selected disabled hidden>Seleccione opción</option>";
													while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
														echo "<option value=\"";
														echo $this_tipo["N_COD_TIPODOC"];
														echo "\"";
														// Si existen registros, ponerlo en el combo
														if ($lb_edit && $this_tipo["N_COD_TIPODOC"] == $array["N_COD_TIPODOC"]){
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
												<label for="id_nro_doc">Numero de Documento</label>
												<input type="text" class="form-control" id="id_nro_doc" name="id_nro_doc" maxlength="20" required pattern="[0-9 ]{1,20}" disabled
													title = "Números. Tamaño máximo: 20" placeholder="(*) Ejemplo : 43515949" value="<?php echo $lb_edit?$array["V_NRO_DOC"]:""; ?>"> 
											</div>
										</div>
										<div class="col-sm-4">
										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_ape_paterno">Apellido Paterno</label>
												<input type="text" class="form-control" id="id_ape_paterno" name="id_ape_paterno" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s ]{1,150}" disabled
													title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Reque" value="<?php echo $lb_edit?$array["V_APE_PATERNO"]:""; ?>">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_ape_materno">Apellido Materno</label>
												<input type="text" class="form-control" id="id_ape_materno" name="id_ape_materno" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s ]{1,150}" disabled 
													title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Llumpo" value="<?php echo $lb_edit?$array["V_APE_MATERNO"]:""; ?>"> 
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_nombres">Nombres</label>
												<input type="text" class="form-control" id="id_nombres" name="id_nombres" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s ]{1,150}" disabled 
													title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Jose Johnny" value="<?php echo $lb_edit?$array["V_NOMBRES"]:""; ?>"> 
											</div>
										</div>										

										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_fec_nacimiento">Fecha de Nacimiento</label>
												<input type="date" class="form-control input-sm" id="id_fec_nacimiento" disabled name="id_fec_nacimiento" 
													title = "Formato Fecha" value="<?php echo $lb_edit?$array["D_FEC_NACIMIENTO"]:""; ?>"> 
											</div>										
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_fg_sexo">Genero</label>
												<?php
												if($lb_edit) {
													$li_sexo = $array['V_FG_SEXO'];
												}else{
													$li_sexo = 'M';
												}
												?>
												<select class="form-control" id="id_fg_sexo" name="id_fg_sexo" required disabled>
												<option value='' selected disabled hidden>Seleccione opción</option>
												<option value="M"<?php if("M" == $li_sexo) echo "selected";?>>Masculino</option>
												<option value="F"<?php if("F" == $li_sexo) echo "selected";?>>Femenino</option>
												</select>			
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_cod_pais">Pais</label>
												<select class="form-control" id="id_cod_pais" name="id_cod_pais" required disabled>
													<?php
													
													// Recuperando datos para combo
													$array_campo_pk	= array('V_FLAG_ESTADO');
													$array_valor_pk	= array('1');
													$array_tipo     = $crud->fila_listar('MAE_PAIS', $array_campo_pk, $array_valor_pk, 'N_COD_PAIS', 'A', 0, 100);

													// Mostrando combo
													echo "<option value='' selected disabled hidden>Seleccione opción</option>";
													while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
														echo "<option value=\"";
														echo $this_tipo["N_COD_PAIS"];
														echo "\"";
														// Si existen registros, ponerlo en el combo
														if ($lb_edit && $this_tipo["N_COD_PAIS"] == $array["N_COD_PAIS"]){
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
												<label for="id_fono">Fono</label>
												<input type="text" class="form-control" id="id_fono" name="id_fono" maxlength="20" pattern="[0-9 ]{1,20}" disabled
													title = "Letras y Números. Tamaño máximo: 20" placeholder="Ejemplo : 043555555" value="<?php echo $lb_edit?$array["V_FONO"]:""; ?>"> 
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_movil">Movil</label>
												<input type="text" class="form-control" id="id_movil" name="id_movil" maxlength="20" required pattern="[0-9 ]{1,20}" disabled
													title = "Números. Tamaño máximo: 20" placeholder="(*) Ejemplo : 977137699" value="<?php echo $lb_edit?$array["V_MOVIL"]:""; ?>"> 
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_email">Email</label>
												<input type="email" class="form-control" id="id_email" name="id_email" maxlength="80" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" disabled
												title = "Letras, Números y carácteres de email. Tamaño máximo: 80" placeholder="Ejemplo : jperez@gmail.com" value="<?php echo $lb_edit?$array["V_EMAIL"]:""; ?>">
											</div>
										</div>

										<div class="col-sm-8">
											<div class="form-group">
												<label for="id_direccion">Dirección</label>
												<input type="text" class="form-control" id="id_direccion" name="id_direccion" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 -_]{1,150}" disabled
													title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Nueva York S/N" value="<?php echo $lb_edit?$array["V_DIRECCION"]:""; ?>">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_referencia">Referencia</label>
												<input type="text" class="form-control" id="id_referencia" name="id_referencia" maxlength="150" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 -_]{1,150}" disabled
													title = "Letras y Números. Tamaño máximo: 150" placeholder="Ejemplo : Al costado de municipio" value="<?php echo $lb_edit?$array["V_REFERENCIA"]:""; ?>">
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_talla">Talla</label>
												<input type="number" class="form-control" id="id_talla" name="id_talla" maxlength="9" min="0" step=any disabled
												title = "Campo numérico" placeholder="Ejemplo : 1.75" value="<?php echo $lb_edit?$array["N_TALLA"]:''; ?>">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_peso">Peso</label>
												<input type="number" class="form-control" id="id_peso" name="id_peso" maxlength="9" min="0" step=any disabled
												title = "Campo numérico" placeholder="Ejemplo : 70" value="<?php echo $lb_edit?$array["N_PESO"]:''; ?>">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_embergadura">Embergadura</label>
												<input type="number" class="form-control" id="id_embergadura" name="id_embergadura" maxlength="9" min="0" step=any disabled
												title = "Campo numérico" placeholder="Ejemplo : 12.75" value="<?php echo $lb_edit?$array["N_EMBERGADURA"]:''; ?>">
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="id_cod_cinturon">Cinturon de Ingreso (Grado)</label>
												<select class="form-control" id="id_cod_cinturon" name="id_cod_cinturon" required disabled>
													<?php
													
													// Recuperando datos para combo
													$array_campo_pk	= array('V_FLAG_ESTADO');
													$array_valor_pk	= array('1');
													$array_tipo     = $crud->fila_listar('MAE_CINTURON', $array_campo_pk, $array_valor_pk, 'N_COD_TIPOGRADO, N_ORDEN', 'A', 0, 100);

													// Mostrando combo
													echo "<option value='' selected disabled hidden>Seleccione opción</option>";
													while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
														echo "<option value=\"";
														echo $this_tipo["N_COD_CINTURON"];
														echo "\"";
														// Si existen registros, ponerlo en el combo
														if ($lb_edit && $this_tipo["N_COD_CINTURON"] == $array["N_COD_CINTURON_ING"]){
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
												<label for="id_cod_sede">Sede</label>
												<select class="form-control" id="id_cod_sede" name="id_cod_sede" required disabled>
													<?php
													
													// Recuperando datos para combo
													$array_campo_pk	= array('V_FLAG_ESTADO');
													$array_valor_pk	= array('1');
													$array_tipo     = $crud->fila_listar('MAE_SEDE', $array_campo_pk, $array_valor_pk, 'V_NOMBRE', 'A', 0, 100);

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
												<label for="id_apoderado">Apoderado</label>
												<input type="text" class="form-control" id="id_apoderado" name="id_apoderado" maxlength="150" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s ]{1,150}" disabled
													title = "Letras y Números. Tamaño máximo: 150" placeholder="Ejemplo : Juna Perez" value="<?php echo $lb_edit?$array["V_APODERADO"]:""; ?>"> 
											</div>
										</div>
										<div class="col-sm-12">
										<input class="btn btn-primary" type="submit" id ="btn_exportar" value="Ver Ficha de Estudiante" formtarget = "_blank" 
										onclick=this.form.action="<?php echo $url_reporte?>">	
										</div>		
									</div>
														
								</form>

							</div>
							<!-- Fin Cuerpo -->

						</div>
						<!-- Fin Panel -->
												
					<?php
					}
				?>					
			</div>

		</div>
	</div>
</section>
<?php
}

/********************************************************/
// Sección Horarios
/********************************************************/
function f_seccion_cambiarclave($as_msgRpta){

// Enlaces
$url_actualizar	= "mae_cambiarclave_actualizar.php";

// Instanciar clase de la B.D
$crud = new crud();

?>
<section class="section-md bg-default">
	<div class="container">
		<div class="row">
		
			<div class="col-md-8 col-lg-4">				
				<img src="../images/t_left_cambioclave.jpg" alt="" />
			</div>

			<div class="col-md-11 col-lg-8">
				<h4 class="heading-decorated">Cambio de Clave</h4>
				<!-- Cuerpo -->
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
				</br>

				<!-- Panel -->
				<div class="panel panel-primary">

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

			</div>

		</div>
	</div>
</section>
<?php
}

?>