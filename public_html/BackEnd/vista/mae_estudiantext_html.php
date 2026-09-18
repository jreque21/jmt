<?php

// Incluye Librería BD
require_once("../config/funciones.php");

// Lista de Usuarios (Cuerpo - Drcha)
function f_listado($as_titulo, $as_icono, $as_msgRpta){

	// Enlaces
	$url_nuevo		= "mae_estudiantext_nuevo.php";
	$url_editar		= "mae_estudiantext_editar.php";
	$url_lista		= "mae_estudiantext_lista.php";
	$url_prog		= "../controlador/mae_estudiantext_usuario.php";
	$url_eliminar	= "../controlador/mae_estudiantext_eliminar.php";

	// Instanciar clase
	$crud = new crud();

	// Preparar Estructura
	$array_campo_pk	= array('V_TIPO_EST');
	$array_valor_pk	= array(DEF_TIPOUSER_ESTEXT);

	// Listado
	$array = $crud->fila_listar(DEF_TABLA_ESTUDIANTE, $array_campo_pk, $array_valor_pk, 'V_APE_PATERNO, V_APE_MATERNO, V_NOMBRES', 'A', 0, 9999);

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
												<th>Documento</th>	
												<th>Apellidos y Nombres</th>
												<th>Edad</th>
												<th>Género</th>																							
												<th>Móvil</th>
												<th>Cinturón Actual</th>
												<th>Usuario</th>
												<th>Estado</th>
												<th>Generar Usuario</th>
												<th>Editar</th>
											</tr>
										</thead>

										<tbody>
											<?php
											while ($row = mysqli_fetch_assoc($array)) {
												$url_editar_fila   = $url_editar."?id_codigo=".($row["N_COD_ESTUDIANTE"]);
												$url_prog_fila	   = $url_prog."?id_codigo=".($row["N_COD_ESTUDIANTE"]);
												$url_eliminar_fila = $url_eliminar."?id_codigo=".($row["N_COD_ESTUDIANTE"]);
												?>
												<tr>
													<?php

													// Tipo Documento
													$array_campo_pk	= array('N_COD_TIPODOC');
													$array_valor_pk	= array($row["N_COD_TIPODOC"]);
													$ls_tipodoc	= $crud->fila_recuperar_campo(DEF_TABLA_TIPO_DOC, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
													$ls_tipodoc = $ls_tipodoc.'-'.$row["V_NRO_DOC"];
													
													echo "<td>";
													echo f_r_url($url_editar_fila, $ls_tipodoc, $row["V_NOMBRES"]);
													echo "</td>";

													echo "<td>";
													echo $row["V_APE_PATERNO"].' '.$row["V_APE_MATERNO"].' '.$row["V_NOMBRES"];
													echo "</td>";

													echo "<td>";
													echo f_get_edad($row["D_FEC_NACIMIENTO"]);
													echo "</td>";

													echo "<td>";
														$ls_fg_sexo =  $row["V_FG_SEXO"];
														if ($ls_fg_sexo =='M') $ls_des_sexo = 'Masculino';
														if ($ls_fg_sexo =='F') $ls_des_sexo = 'Femenino';
														echo $ls_des_sexo;
													echo "</td>";

													echo "<td>";
													echo $row["V_MOVIL"];
													echo "</td>";

													// Cinturón Actual
													$li_cinturon_actual = $crud->f_get_cinturonActual($row["N_COD_ESTUDIANTE"]);
													$array_campo_pk	= array('N_COD_CINTURON');
													$array_valor_pk	= array($li_cinturon_actual);
													$ls_cinturon	= $crud->fila_recuperar_campo(DEF_TABLA_CINTURON, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');
													echo "<td>";
													echo $ls_cinturon;
													echo "</td>";

													// Definir estructura
													$array_campo_pk	= array('V_COD_TIPO', 'N_COD_REFERENCIA', 'V_FLAG_ESTADO');
													$array_valor_pk	= array(DEF_TIPOUSER_ESTEXT, $row["N_COD_ESTUDIANTE"], '1');

													// Invocar CRUD
													$li_contador = $crud->fila_contar(DEF_TABLA_USUARIO, $array_campo_pk, $array_valor_pk);
													echo "<td>";
														if ($li_contador == 0) {
															$ls_flag_user = 'No';
														} else {
															$ls_flag_user = 'Si';
														}
														echo $ls_flag_user;
													echo "</td>";

													echo "<td>";
														$ls_estado =  $row["V_FLAG_ESTADO"];
														if ($ls_estado =='0') $estado = 'Inactivo';
														if ($ls_estado =='1') $estado = 'Activo';
														echo $estado;
													echo "</td>";

													echo "<td align='center'>";
													?>
													<a href="<?php echo $url_prog_fila?>">
														<i class="fa fa-gears"></i>
													</a>
													<?php
													echo "</td>";	

													echo "<td align='center'>";
													?>
													<a href="<?php echo $url_editar_fila?>">
														<i class="fa fa-edit"></i>
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
						<span class="glyphicon glyphicon-plus"></span>&nbsp;Nuevo Registro
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
	$url_lista		= "mae_estudiantext_lista.php";
	$url_registrar	= "../controlador/mae_estudiantext_registrar.php";
	$url_actualizar	= "../controlador/mae_estudiantext_actualizar.php";
	$url_eliminar	= "../controlador/mae_estudiantext_eliminar.php";

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

									<div class="col-sm-8">

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label for="id_codigo">Código</label>
													<input type="text" class="form-control" id="id_codigo" name="id_codigo" maxlength="5" disabled
														title = "Generado por el sistema" placeholder="Codigo autogenerado" value="<?php echo $lb_edit?$array["N_COD_ESTUDIANTE"]:""; ?>">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label for="id_fec_alta">Fecha de Ingreso</label>
													<input type="date" class="form-control input-sm" id="id_fec_alta" name="id_fec_alta" autofocus required"
														title = "Formato Fecha" value="<?php echo $lb_edit?$array["D_FEC_ALTA"]:""; ?>"> 
												</div>										
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label for="id_tipo_doc">Tipo de Documento</label>
													<select class="form-control" id="id_tipo_doc" name="id_tipo_doc" required>
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
											<div class="col-sm-6">
												<div class="form-group">
													<label for="id_nro_doc">Numero de Documento</label>
													<input type="text" class="form-control" id="id_nro_doc" name="id_nro_doc" maxlength="20" required pattern="[0-9 ]{1,20}"
														title = "Números. Tamaño máximo: 20" placeholder="(*) Ejemplo : 43515949" value="<?php echo $lb_edit?$array["V_NRO_DOC"]:""; ?>"> 
												</div>
											</div>
										</div>	
										
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label for="id_ape_paterno">Apellido Paterno</label>
													<input type="text" class="form-control" id="id_ape_paterno" name="id_ape_paterno" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s ]{1,150}"
														title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Reque" value="<?php echo $lb_edit?$array["V_APE_PATERNO"]:""; ?>">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label for="id_ape_materno">Apellido Materno</label>
													<input type="text" class="form-control" id="id_ape_materno" name="id_ape_materno" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s ]{1,150}" 
														title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Llumpo" value="<?php echo $lb_edit?$array["V_APE_MATERNO"]:""; ?>"> 
												</div>
											</div>
										</div>

									</div>

									<div class="col-sm-4 text-center">
										<div class="form-group">			
											<?php if($lb_edit){
												if(strlen($array["V_FOTO"])>1){
												?>	
												</br>
												<img class="img-responsive img-thumbnail" src="../../upload/<?php echo DEF_UPLOAD_ESTUDIANTE_DIR.'/'.$array["V_FOTO"];?>" width="160px">
												<?php
												}	
											}?>
										</div>
									</div>

								</div>

								<div class="row">
									
									<div class="col-sm-8">
										<div class="form-group">
											<label for="id_nombres">Nombres</label>
											<input type="text" class="form-control" id="id_nombres" name="id_nombres" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s ]{1,150}" 
												title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Jose Johnny" value="<?php echo $lb_edit?$array["V_NOMBRES"]:""; ?>"> 
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_tipo_est">Tipo de Estudiante</label>
											<input type="text" class="form-control" id="id_tipo_est" name="id_tipo_est" maxlength="150" disabled
												title = "Letras. Tamaño máximo: 150" value="INTERNO"> 
										</div>
									</div>

								</div>
								
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_fec_nacimiento">Fecha de Nacimiento</label>
											<input type="date" class="form-control input-sm" id="id_fec_nacimiento" name="id_fec_nacimiento" "
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
											<select class="form-control" id="id_fg_sexo" name="id_fg_sexo" required>
											<option value='' selected disabled hidden>Seleccione opción</option>
											<option value="M"<?php if("M" == $li_sexo) echo "selected";?>>Masculino</option>
											<option value="F"<?php if("F" == $li_sexo) echo "selected";?>>Femenino</option>
											</select>			
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_pais">Pais</label>
											<select class="form-control" id="id_cod_pais" name="id_cod_pais" required>
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
								</div>

								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_fono">Fono</label>
											<input type="text" class="form-control" id="id_fono" name="id_fono" maxlength="20" pattern="[0-9 ]{1,20}"
												title = "Letras y Números. Tamaño máximo: 20" placeholder="Ejemplo : 043555555" value="<?php echo $lb_edit?$array["V_FONO"]:""; ?>"> 
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_movil">Movil</label>
											<input type="text" class="form-control" id="id_movil" name="id_movil" maxlength="20" required pattern="[0-9 ]{1,20}"
												title = "Números. Tamaño máximo: 20" placeholder="(*) Ejemplo : 977137699" value="<?php echo $lb_edit?$array["V_MOVIL"]:""; ?>"> 
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_email">Email</label>
											<input type="email" class="form-control" id="id_email" name="id_email" maxlength="80" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
											title = "Letras, Números y carácteres de email. Tamaño máximo: 80" placeholder="Ejemplo : jperez@gmail.com" value="<?php echo $lb_edit?$array["V_EMAIL"]:""; ?>">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-8">
										<div class="form-group">
											<label for="id_direccion">Dirección</label>
											<input type="text" class="form-control" id="id_direccion" name="id_direccion" maxlength="150" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 -_]{1,150}"
												title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Nueva York S/N" value="<?php echo $lb_edit?$array["V_DIRECCION"]:""; ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_referencia">Referencia</label>
											<input type="text" class="form-control" id="id_referencia" name="id_referencia" maxlength="150" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 -_]{1,150}"
												title = "Letras y Números. Tamaño máximo: 150" placeholder="Ejemplo : Al costado de municipio" value="<?php echo $lb_edit?$array["V_REFERENCIA"]:""; ?>">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_talla">Talla</label>
											<input type="number" class="form-control" id="id_talla" name="id_talla" maxlength="9" min="0" step=any
											title = "Campo numérico" placeholder="Ejemplo : 1.75" value="<?php echo $lb_edit?$array["N_TALLA"]:''; ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_peso">Peso</label>
											<input type="number" class="form-control" id="id_peso" name="id_peso" maxlength="9" min="0" step=any
											title = "Campo numérico" placeholder="Ejemplo : 70" value="<?php echo $lb_edit?$array["N_PESO"]:''; ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_embergadura">Embergadura</label>
											<input type="number" class="form-control" id="id_embergadura" name="id_embergadura" maxlength="9" min="0" step=any
											title = "Campo numérico" placeholder="Ejemplo : 12.75" value="<?php echo $lb_edit?$array["N_EMBERGADURA"]:''; ?>">
										</div>
									</div>
								</div>

								<div class="row">
									
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_cinturon">Cinturon de Ingreso (Grado)</label>
											<select class="form-control" id="id_cod_cinturon" name="id_cod_cinturon" required>
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
											<label for="id_apoderado">Apoderado</label>
											<input type="text" class="form-control" id="id_apoderado" name="id_apoderado" maxlength="150" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s ]{1,150}" 
												title = "Letras y Números. Tamaño máximo: 150" placeholder="Ejemplo : Juna Perez" value="<?php echo $lb_edit?$array["V_APODERADO"]:""; ?>"> 
										</div>
									</div>
									
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_academia">Academia</label>
											<select class="form-control" id="id_cod_academia" name="id_cod_academia" required>
												<?php
												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_ACADEMIA, $array_campo_pk, $array_valor_pk, 'V_DESCRIPCION', 'A', 0, 999);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_ACADEMIA"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_ACADEMIA"] == $array["N_COD_ACADEMIA"]){
														echo " selected";
													}
													echo ">";
													echo $this_tipo["V_DESCRIPCION"];
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
											<label for="id_fec_baja">Fecha de Baja</label>
											<input type="date" class="form-control input-sm" id="id_fec_baja" name="id_fec_baja" "
												title = "Formato Fecha" value="<?php echo $lb_edit?$array["D_FEC_BAJA"]:""; ?>"> 
										</div>										
									</div>
									<div class="col-sm-8">
										<div class="form-group">
											<label for="id_motivo_baja">Motivo de Baja</label>
											<textarea class="form-control" rows="3" id="id_motivo_baja" name="id_motivo_baja" placeholder="Ejemplo : Renuncia" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 -_]{1,150}"><?php echo $lb_edit?$array["V_MOTIVO_BAJA"]:""; ?></textarea>
										</div>	
									</div>
								</div>	

								<div class="form-group">
									<label for="id_imagen">Adjuntar Foto</label>
									<input type="file" id="archivo" name="archivo">
								</div>

								<div class="checkbox">
									<?php
									if($lb_edit) {
										$ls_estado = $array['V_FLAG_ESTADO'];
									}else{
										$ls_estado = '1';
									}
									?>
									<label>
									<input type="checkbox" id="id_flag_estado" name="id_flag_estado" <?php if("0" <> $ls_estado) echo "checked";?> value="1"> Activo ?
									</label>
								</div>

								<?php
								if ($lb_edit) {
									echo "<input type=hidden name=id_codigo value=\"".$array["N_COD_ESTUDIANTE"]."\">";
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

?>