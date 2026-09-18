<?php

// Incluye Librería BD
require_once("../config/funciones.php");

// Lista de Usuarios (Cuerpo - Drcha)
function f_listado($as_titulo, $as_icono, $as_msgRpta){

	// Enlaces
	$url_nuevo		= "mae_cinturon_nuevo.php";
	$url_editar		= "mae_cinturon_editar.php";
	$url_lista		= "mae_cinturon_lista.php";
	$url_eliminar	= "../controlador/mae_cinturon_eliminar.php";

	// Instanciar clase
	$crud = new crud();

	// Armar Estructura
	$array_campo_pk = [];
	$array_valor_pk = [];

	// Listado
	$array = $crud->fila_listar(DEF_TABLA_CINTURON, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA', 'A', 0, 100);

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
												<th>Código</th>
												<th>Descripción Corta</th>
												<th>Color</th>
												<th>Imagen</th>
												<th>Orden</th>
												<th>Tipo de Grado</th>
												<th>Estado</th>
												<th>Editar</th>
												<th>Eliminar</th>
											</tr>
										</thead>

										<tbody>
											<?php
											while ($row = mysqli_fetch_assoc($array)) {
												$url_editar_fila   = $url_editar."?id_codigo=".($row["N_COD_CINTURON"]);
												$url_eliminar_fila = $url_eliminar."?id_codigo=".($row["N_COD_CINTURON"]);
												?>
												<tr>
													<?php

													echo "<td>";
													echo f_r_url($url_editar_fila, $row["N_COD_CINTURON"],$row["V_DES_LARGA"]);
													echo "</td>";

													echo "<td>";
													echo $row["V_DES_CORTA"];
													echo "</td>";

													echo "<td>";
													echo "<table border='1' width='100%''><tr><td bgcolor=".$row["V_COD_COLOR"].">&nbsp;</td></tr></table>";
													echo "</td>";

													echo "<td>";
													?>														
													<img class="img-responsive img-thumbnail" src="../../upload/<?php echo DEF_UPLOAD_CINTURON_DIR.'/'.$row["V_FOTO"];?>">
													<?php													
													echo "</td>";

													echo "<td>";
													echo $row["N_ORDEN"];
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

													echo "<td align='center'>";
													?>
													<a href="<?php echo $url_editar_fila?>">
														<i class="fa fa-edit"></i>
													</a>
													<?php
													echo "</td>";

													echo "<td align='center'>";
													?>
													<a href="#deleteModal<?php echo $row["N_COD_CINTURON"]; ?>" data-toggle="modal" ><i class="fa fa-trash-o"></i></a>
													<div id="deleteModal<?php echo $row["N_COD_CINTURON"]; ?>" class="modal fade">
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
	$url_lista		= "mae_cinturon_lista.php";
	$url_registrar	= "../controlador/mae_cinturon_registrar.php";
	$url_actualizar	= "../controlador/mae_cinturon_actualizar.php";
	$url_eliminar	= "../controlador/mae_cinturon_eliminar.php";

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
								
								<div class="form-group">
									<label for="id_codigo">Código</label>
									<input type="text" class="form-control" id="id_codigo" name="id_codigo" maxlength="5" disabled
										title = "Generado por el sistema" placeholder="Codigo autogenerado" value="<?php echo $lb_edit?$array["N_COD_CINTURON"]:""; ?>">
								</div>
								
								<div class="form-group">
									<label for="id_des_larga">Descripción Larga</label>
									<input type="text" class="form-control" id="id_des_larga" name="id_des_larga" maxlength="150" required pattern="[[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 ]]{1,150}" autofocus
										title = "Letras y Números. Tamaño máximo: 150" placeholder="(*) Ejemplo : Blanco punta amarilla" value="<?php echo $lb_edit?$array["V_DES_LARGA"]:""; ?>">
								</div>

								<div class="form-group">
									<label for="id_des_corta">Descripción Corta</label>
									<input type="text" class="form-control" id="id_des_corta" name="id_des_corta" maxlength="100" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s0-9 ]{1,100}"
										title = "Letras y Números. Tamaño máximo: 100" placeholder="(*) Ejemplo : Blanco punta amarillo" value="<?php echo $lb_edit?$array["V_DES_CORTA"]:""; ?>">
								</div>
								
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_color">Color</label>
											<input type="color" class="form-control" id="id_color" name="id_color" maxlength="20"
												title = "Letras y Números. Tamaño máximo: 20" placeholder="Ejemplo : #000000 (Negro)" value="<?php echo $lb_edit?$array["V_COD_COLOR"]:""; ?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_orden">Orden</label>
											<?php
											if($lb_edit) {
												$li_orden = $array["N_ORDEN"];
											}else{
												$li_orden = 0;
											}	
											?>
											<select class="form-control" id="id_orden" name="id_orden" required>
											<option value='' selected disabled hidden>Seleccione opción</option>
											<option value="1"<?php if("1" == $li_orden) echo "selected";?>>1</option>
											<option value="2"<?php if("2" == $li_orden) echo "selected";?>>2</option>
											<option value="3"<?php if("3" == $li_orden) echo "selected";?>>3</option>
											<option value="4"<?php if("4" == $li_orden) echo "selected";?>>4</option>
											<option value="5"<?php if("5" == $li_orden) echo "selected";?>>5</option>
											<option value="6"<?php if("6" == $li_orden) echo "selected";?>>6</option>
											<option value="7"<?php if("7" == $li_orden) echo "selected";?>>7</option>
											<option value="8"<?php if("8" == $li_orden) echo "selected";?>>8</option>
											<option value="9"<?php if("9" == $li_orden) echo "selected";?>>9</option>
											<option value="10"<?php if("10" == $li_orden) echo "selected";?>>10</option>
											<option value="11"<?php if("11" == $li_orden) echo "selected";?>>11</option>
											<option value="12"<?php if("12" == $li_orden) echo "selected";?>>12</option>
											<option value="13"<?php if("13" == $li_orden) echo "selected";?>>13</option>
											<option value="14"<?php if("14" == $li_orden) echo "selected";?>>14</option>
											<option value="15"<?php if("15" == $li_orden) echo "selected";?>>15</option>
											<option value="15"<?php if("16" == $li_orden) echo "selected";?>>16</option>
											<option value="15"<?php if("17" == $li_orden) echo "selected";?>>17</option>
											<option value="15"<?php if("18" == $li_orden) echo "selected";?>>18</option>
											<option value="15"<?php if("19" == $li_orden) echo "selected";?>>19</option>
											<option value="15"<?php if("20" == $li_orden) echo "selected";?>>20</option>
											</select>			
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="id_tipo_grado">Tipo de Grado</label>
											<select class="form-control" id="id_tipo_grado" name="id_tipo_grado" required>
												<?php
												
												// Recuperando datos para combo
												$array_campo_pk	= array('V_FLAG_ESTADO');
												$array_valor_pk	= array('1');
												$array_tipo     = $crud->fila_listar(DEF_TABLA_TIPOGRADO, $array_campo_pk, $array_valor_pk, 'V_DES_CORTA', 'A', 0, 100);

												// Mostrando combo
												echo "<option value='' selected disabled hidden>Seleccione opción</option>";
												while ($this_tipo = mysqli_fetch_assoc($array_tipo)) {
													echo "<option value=\"";
													echo $this_tipo["N_COD_TIPOGRADO"];
													echo "\"";
													// Si existen registros, ponerlo en el combo
													if ($lb_edit && $this_tipo["N_COD_TIPOGRADO"] == $array["N_COD_TIPOGRADO"]){
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

								<div class="form-group">
									<label for="id_texto">Resumen</label>
									<div id="id_texto">										
										<textarea class="form-control" rows="3" id="id_texto" name="id_texto" placeholder="Introduce resumen"><?php echo $lb_edit?$array["V_TEXTO"]:""; ?></textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label for="id_imagen">Adjuntar una Imagen</label>
									<input type="file" id="archivo" name="archivo">					
									<?php if($lb_edit){
										if(strlen($array["V_FOTO"])>1){
										?>	
										</br>
										<img class="img-responsive img-thumbnail" src="../../upload/<?php echo DEF_UPLOAD_CINTURON_DIR.'/'.$array["V_FOTO"];?>" width="150px">
										<?php
										}	
									}?>
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
									echo "<input type=hidden name=id_codigo value=\"".$array["N_COD_CINTURON"]."\">";
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