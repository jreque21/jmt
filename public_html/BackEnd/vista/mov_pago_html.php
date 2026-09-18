<?php

// Incluye Librería BD
require_once("../config/funciones.php");

// Lista de Créditos (Cuerpo - Drcha)
function f_listado_creditos($as_titulo, $as_icono, $as_msgRpta){

	// Enlaces
	$url_lista		= "mov_creditos_lista.php";
	$url_detalle	= "mov_pago_lista.php";

	// Instanciar clase
	$crud = new crud();

	// Armar Estructura
	$array_campo_pk = ['V_FLAG_PAGO'];
	$array_valor_pk = ['0'];

	// Listado
	$array = $crud->fila_listar_not_in(DEF_TABLA_MATRICULA, $array_campo_pk, $array_valor_pk, DEF_TABLA_HORARIO, 'N_COD_HORARIO', 'V_FLAG_ESTADO', '0', 'N_COD_MATRICULA', 'A', 0, 999);

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
												<th>Estudiante</th>
												<th>Documento</th>
												<th>Edad</th>
												<th>Móvil</th>
												<th>Sede</th>
												<th>Horario</th>
												<th>Fecha Matrícula</th>												
												<th>Moneda</th>
												<th>Monto</th>
												<th>Ver Pagos</th>
											</tr>
										</thead>

										<tbody>
											<?php
											while ($row = mysqli_fetch_assoc($array)) {
												$url_detalle_fila	= $url_detalle."?id_codigo_padre=".($row["N_COD_MATRICULA"]);
												?>
												<tr>
													<?php

													// Padrón Estudiante
													$array_campo_pk	= array('N_COD_ESTUDIANTE');
													$array_valor_pk	= array($row["N_COD_ESTUDIANTE"]);
													$array_padron 	= $crud->fila_recuperar(DEF_TABLA_ESTUDIANTE, $array_campo_pk, $array_valor_pk);

													echo "<td>";
													echo $array_padron['V_APE_PATERNO'].' '.$array_padron['V_APE_MATERNO'].' '.$array_padron['V_NOMBRES'];
													echo "</td>";

													echo "<td>";
													echo $array_padron["V_NRO_DOC"];
													echo "</td>";

													echo "<td>";
													echo f_get_edad($array_padron["D_FEC_NACIMIENTO"]);
													echo "</td>";

													echo "<td>";
													echo $array_padron["V_MOVIL"];
													echo "</td>";

													// Horario
													$array_campo_pk	= array('N_COD_HORARIO');
													$array_valor_pk	= array($row["N_COD_HORARIO"]);
													$array_horario 	= $crud->fila_recuperar(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk);

													// Sede
													$array_campo_pk	= array('N_COD_SEDE');
													$array_valor_pk	= array($array_horario["N_COD_SEDE"]);
													$ls_sede		= $crud->fila_recuperar_campo(DEF_TABLA_SEDE, $array_campo_pk, $array_valor_pk, 'V_NOMBRE');
													
													// Moneda
													$array_campo_pk	= array('N_COD_MONEDA');
													$array_valor_pk	= array($row["N_COD_MONEDA"]);
													$ls_moneda		= $crud->fila_recuperar_campo(DEF_TABLA_MONEDA, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA');

													echo "<td>";
													echo $ls_sede;
													echo "</td>";

													echo "<td>";
													echo $array_horario["V_DESCRIPCION"];
													echo "</td>";

													echo "<td>";
													echo $row["D_FEC_MATRICULA"];
													echo "</td>";

													echo "<td>";
													echo $ls_moneda;
													echo "</td>";

													echo "<td>";
													echo $row["N_MONTO_NETO"];
													echo "</td>";

													echo "<td align='center'>";
													?>
													<a href="<?php echo $url_detalle_fila?>">
														<i class="fa fa-search" title = "Detalle de Pagos"></i>
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

// Lista (Cuerpo - Drcha)
function f_listado($as_titulo, $as_icono, $as_msgRpta, $an_id_codigo_padre){

	// Enlaces
	$url_nuevo		= "mov_pago_nuevo.php?id_codigo_padre=".$an_id_codigo_padre;
	$url_editar		= "mov_pago_editar.php?id_codigo_padre=".$an_id_codigo_padre;
	$url_lista		= "mov_creditos_lista.php";
	$url_eliminar	= "../controlador/mov_pago_eliminar.php?id_codigo_padre=".$an_id_codigo_padre;

	// Instanciar clase
	$crud = new crud();

	// Armar Estructura
	$array_campo_pk = ['N_COD_MATRICULA'];
	$array_valor_pk = [$an_id_codigo_padre];

	// Listado
	$array = $crud->fila_listar(DEF_TABLA_PAGO, $array_campo_pk, $array_valor_pk, 'N_ITEM', 'A', 0, 1000);

	// Matrícula
	$array_campo_pk	= array('N_COD_MATRICULA');
	$array_valor_pk	= array($an_id_codigo_padre);
	$array_matricula= $crud->fila_recuperar(DEF_TABLA_MATRICULA, $array_campo_pk, $array_valor_pk);

	// Horario
	$array_campo_pk	= array('N_COD_HORARIO');
	$array_valor_pk	= array($array_matricula['N_COD_HORARIO']);
	$array_horario 	= $crud->fila_recuperar(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk);
	
	// Padrón Estudiante
	$array_campo_pk	= array('N_COD_ESTUDIANTE');
	$array_valor_pk	= array($array_matricula['N_COD_ESTUDIANTE']);
	$array_padron 	= $crud->fila_recuperar(DEF_TABLA_ESTUDIANTE, $array_campo_pk, $array_valor_pk);
	
	// Saldo Pendiente
	$li_monto_pendiente	= $crud->f_get_saldoPendiente($an_id_codigo_padre);

	?>

	<!-- Sección Contenido -->
	<div class="content-wrapper">

		<!-- Cabecera de Sección Contenido -->
		<section class="content-header">
			<h1>
			<i class="<?php echo $as_icono;?>"></i> <?php echo $as_titulo.' - Pagos';?>
			</h1>
			</br>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page">
					<?php 
					echo '<b>Horario : </b>'.$array_horario['V_DESCRIPCION'];
					echo ' &nbsp;&nbsp; | &nbsp;&nbsp; <b>Estudiante : </b>'.$array_padron['V_APE_PATERNO'].' '.$array_padron['V_APE_MATERNO'].' '.$array_padron['V_NOMBRES'];
					echo ' &nbsp;&nbsp; | &nbsp;&nbsp; <b>Saldo Pendiente : </b>'.number_format($li_monto_pendiente, 2, '.', ' ');
					?></li>
				</ol>
			</nav>
			<ol class="breadcrumb">
				<li><a href="<?php echo DEF_URL_LOGIN;?>"><i class="fa fa-home"></i> Inicio</a></li>
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
												<th>Matrícula</th>
												<th>Nº Item</th>
												<th>Estudiante</th>
												<th>Fecha Matrícula</th>
												<th>Fecha Pago</th>
												<th>Moneda</th>
												<th>Monto</th>
												<th>Medio Pago</th>												
												<th>Editar</th>
												<th>Eliminar</th>
											</tr>
										</thead>

										<tbody>
											<?php
											while ($row = mysqli_fetch_assoc($array)) {
												$url_editar_fila   = $url_editar."&id_codigo=".($row["N_ITEM"]);
												$url_eliminar_fila = $url_eliminar."&id_codigo=".($row["N_ITEM"]);
												?>
												<tr>
													<?php
													
													echo "<td>";
													echo $array_horario["V_DESCRIPCION"];
													echo "</td>";

													echo "<td>";
													echo $row["N_ITEM"];
													echo "</td>";

													echo "<td>";
													echo $array_padron['V_APE_PATERNO'].' '.$array_padron['V_APE_MATERNO'].' '.$array_padron['V_NOMBRES'];
													echo "</td>";

													echo "<td>";
													echo $array_matricula["D_FEC_MATRICULA"];
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
													
													echo "<td align='center'>";
													?>
													<a href="<?php echo $url_editar_fila?>">
														<i class="fa fa-edit" title = "Editar registro"></i>
													</a>
													<?php
													echo "</td>";
													
													echo "<td align='center'>";
													?>
													<a href="#deleteModal<?php echo $row["N_ITEM"]; ?>" data-toggle="modal" ><i class="fa fa-trash-o"></i></a>
													<div id="deleteModal<?php echo $row["N_ITEM"]; ?>" class="modal fade">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	<h4 class="modal-title">Aviso de Confirmación</h4>
																</div>
																<div class="modal-body">
																	<p>¿ Seguro que quieres borrar este elemento ?</p>
																	<p class="text-warning"><small>Si lo borras, nunca podrás recuperarlo.</small></p>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
																	<a class="btn btn-danger" href="<?php echo $url_eliminar_fila?>" role="button">
																		Eliminar
																	</a>
																</div>
															</div>
														</div>
													</div>												
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
						<span class="glyphicon glyphicon-plus"></span>&nbsp;Nuevo Pago
					</a>
					
					<a class="btn btn-primary" href="<?php echo $url_lista?>" role="button">
						Regresar
					</a>

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
function f_formulario($as_titulo, $as_icono, $as_msgRpta, $array = "", $an_id_codigo_padre) {

	//Inicalizando variables
	$lb_edit = is_array($array);
	$inhabilitado = "disabled='disabled'";

	// Instanciar clase
	$crud = new crud();

	// Gestionar código de padre
	if($an_id_codigo_padre) {
		$li_id_codigo_padre = $an_id_codigo_padre;
		$array_campo_pk	= array('N_COD_MATRICULA');
		$array_valor_pk	= array($li_id_codigo_padre);
		$li_cod_moneda	= $crud->fila_recuperar_campo(DEF_TABLA_MATRICULA, $array_campo_pk, $array_valor_pk, 'N_COD_MONEDA');
		$li_monto		= $crud->f_get_saldoPendiente($li_id_codigo_padre);
		$li_item		= $crud->fila_recuperar_lastIdPar(DEF_TABLA_PAGO, $array_campo_pk, $array_valor_pk, 'N_ITEM')+1;
		$ld_fecha_hoy   = date('Y-m-d');
	}else{
		$li_id_codigo_padre = $array["N_COD_MATRICULA"];
		$li_item			= $array["N_ITEM"];
		$li_cod_moneda 		= $array["N_COD_MONEDA"];
		$li_monto			= $crud->f_get_saldoPendiente($li_id_codigo_padre);
		// Enlaces
		$url_eliminar	= "../controlador/mov_pago_eliminar.php?id_codigo_padre=".$li_id_codigo_padre."&id_codigo=".$array['N_ITEM'];
	}

	// Matrícula
	$array_campo_pk	= array('N_COD_MATRICULA');
	$array_valor_pk	= array($li_id_codigo_padre);
	$array_matricula= $crud->fila_recuperar(DEF_TABLA_MATRICULA, $array_campo_pk, $array_valor_pk);

	// Horario
	$array_campo_pk	= array('N_COD_HORARIO');
	$array_valor_pk	= array($array_matricula['N_COD_HORARIO']);
	$array_horario 	= $crud->fila_recuperar(DEF_TABLA_HORARIO, $array_campo_pk, $array_valor_pk);
	
	// Padrón Estudiante
	$array_campo_pk	= array('N_COD_ESTUDIANTE');
	$array_valor_pk	= array($array_matricula['N_COD_ESTUDIANTE']);
	$array_padron 	= $crud->fila_recuperar(DEF_TABLA_ESTUDIANTE, $array_campo_pk, $array_valor_pk);

	// Enlaces
	$url_lista		= "mov_pago_lista.php?id_codigo_padre=".$li_id_codigo_padre;
	$url_registrar	= "../controlador/mov_pago_registrar.php";
	$url_actualizar	= "../controlador/mov_pago_actualizar.php";

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
			<i class="<?php echo $as_icono;?>"></i> <?php echo $as_titulo.' - Pagos';
			?>
			</h1>
			</br>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page">
					<?php 
					echo '<b>Horario : </b>'.$array_horario['V_DESCRIPCION'];
					echo ' &nbsp;&nbsp; | &nbsp;&nbsp; <b>Estudiante : </b>'.$array_padron['V_APE_PATERNO'].' '.$array_padron['V_APE_MATERNO'].' '.$array_padron['V_NOMBRES'];
					echo ' &nbsp;&nbsp; | &nbsp;&nbsp; <b>Saldo Pendiente : </b>'.number_format($li_monto, 2, '.', ' ');
					?></li>
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

							<form  id="form_mtto" role="form" method="post" action="" enctype="multipart/form-data" autocomplete="off">
								
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_codigo">Código</label>
											<input type="text" class="form-control" id="id_codigo" name="id_codigo" maxlength="10" disabled
												title = "Generado por el sistema" placeholder="Codigo autogenerado" value="<?php echo $lb_edit?$array["N_ITEM"]:$li_item; ?>"> 
											<input type="hidden" class="form-control" id="id_cod_matricula_hide" name="id_cod_matricula_hide"  
												 value="<?php echo $li_id_codigo_padre; ?>"> 
											<input type="hidden" class="form-control" id="id_item_hide" name="id_item_hide"  
												 value="<?php echo $li_item; ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_fec_pago">Fecha Pago</label>
											<input type="date" class="form-control input-sm" id="id_fec_pago" name="id_fec_pago" required"
												title = "Formato Fecha" value="<?php echo $lb_edit?$array["D_FEC_PAGO"]:$ld_fecha_hoy; ?>"> 
										</div>	
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_moneda">Moneda</label>
											<select class="form-control" id="id_cod_moneda" name="id_cod_moneda" required>
												<?php												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_MONEDA, $array_campo_pk, $array_valor_pk, 'N_COD_MONEDA', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_MONEDA"];
													echo "\""; 
													// Si existen registros, ponerlo en el combo
													if ($this_tipo["N_COD_MONEDA"] == $li_cod_moneda){
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
											<label for="id_monto">Monto</label>
											<input type="number" class="form-control" id="id_monto" name="id_monto" maxlength="9" min="0" required
											title = "Campo numérico" placeholder="(*) Ejemplo : 12.75" value="<?php echo $lb_edit?$array["N_MONTO"]:$li_monto; ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_cod_mediopago">Medio de Pago</label>
											<select class="form-control" id="id_cod_mediopago" name="id_cod_mediopago" required>
												<?php												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_MEDIOPAGO, $array_campo_pk, $array_valor_pk, 'N_COD_MEDIOPAGO', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_MEDIOPAGO"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_MEDIOPAGO"] == $array["N_COD_MEDIOPAGO"]){
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
											<label for="id_comprobante">Comprobante</label>
											<input type="text" class="form-control" id="id_comprobante" name="id_comprobante" maxlength="100" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 -_()]{1,100}"
												title = "Letras y Números. Tamaño máximo: 100" placeholder="Ejemplo : FACT-2023-001" value="<?php echo $lb_edit?$array["V_COMPROBANTE"]:""; ?>">
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="id_observacion">Observaciones</label>
									<textarea class="form-control" rows="3" id="id_observacion" name="id_observacion" placeholder="Ejemplo : Cuota Nª 1"><?php echo $lb_edit?$array["V_OBSERVACION"]:""; ?></textarea>
								</div>

								<?php
								if ($lb_edit) {
									echo "<input type=hidden name=id_codigo value=\"".$array["N_ITEM"]."\">";
									?>
									<input class="btn btn-success" type="submit" id ="btn_actualizar" value="Actualizar" onclick=this.form.action="<?php echo $url_actualizar?>">
									<input class="btn btn-danger" type="submit" id ="btn_eliminar" value="Eliminar" formnovalidate onclick=this.form.action="<?php echo $url_eliminar?>">
									<a class="btn btn-primary" href="<?php echo $url_lista?>" role="button">Cancelar</a>
									<?php
								} else {
									?>
									<input class="btn btn-success" type="submit" id ="btn_agregar" value="Guardar" onclick=this.form.action="<?php echo $url_registrar?>">
									<a class="btn btn-primary" href="<?php echo $url_lista?>" role="button">Cancelar</a>
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