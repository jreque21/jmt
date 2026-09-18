<?php

// Funcion carga y redimensiona imagen archivo al servidor
function f_upload_archivo($archivo, $carpeta, $tipo, $valor1, $valor2) {
	
	// Carga libreria de upload
    //require_once("../recursos/upload/class.upload.php");
    include('../recursos/upload/class.upload.php');
	
	// Asigna Ruta
	$carpeta = "../../upload/$carpeta";

	// Recupera peso
	$peso  = $_FILES["archivo"]["size"];
    
	//Verificamos tamaño . .
    $kilobytes = $peso/1024;	// Obtenemos peso en kb    
    $megas = $kilobytes/1024;	// Obtenemos peso en megas    
	// Validar Peso
	if ($megas > 10 ) {
        echo 'El archivo cargado supera los 10 Megas';
		?>
		<input type="button" value="Retornar" title="Retornar" onclick="history.back()" />
        <?php
    }
	
	// Instanciar la clase
	$handle = new Verot\Upload\Upload($archivo);
    
    // Segùn caso
	if ($handle->uploaded) {
		$handle->image_resize  = true;
		if ($tipo == 'W'){ // Width
			$handle->image_ratio_y		= true;
			$handle->image_x        	= $valor1;
		}
		if ($tipo == 'H'){ // Height
			$handle->image_ratio_x  	= true;
			$handle->image_y        	= $valor1;
		}
		if ($tipo == 'C'){ // Crop
			$handle->image_ratio_crop 	= true;
			$handle->image_x        	= $valor1;
			$handle->image_y            = $valor2;
		}else{
			$handle->image_ratio    	= true;
			$handle->image_x        	= $valor1;
			$handle->image_y        	= $valor2;
		}	

        // Procesar Carpeta
		$handle->Process($carpeta);
        
        // Fue procesado ?
		if ($handle->processed){
			$cadena = $handle->file_dst_pathname;
			$pos = strrpos($cadena,"/"); // \\ JR 2020
			$nombre = substr($cadena, $pos+1);
		}else{
			$nombre = "";
		}

	}

    // Retornar
	return $nombre;

}	

//Funcion cargando archivo al servidor
function f_carga_archivo($archivo, $carpeta) {
    //Recuperando datos de archivo ..
    $archivo = $_FILES["archivo"]["name"];
    $temp    = $_FILES["archivo"]["tmp_name"];
    $tamano  = $_FILES["archivo"]["size"];
    $tipo    = $_FILES["archivo"]["type"];

    //Verificamos tamaño . .
    $kilobytes = $tamano/1024;//con esto temenos la cantidad en kb (
    $megas = $kilobytes/1024;

    if ($megas > 10 ) {
        echo '<div id="msg_error">El archivo cargado supera los 10 megas</div>';
        ?>
<br />
<input type="button" value="Volver" title="Volver" onclick="history.back()" />
        <?php
    }

    //Ahora validamos la extension o el tipo de archivo ..
    if ($tipo=="application/pdf" or $tipo=="image/jpeg" or $tipo=="image/jpg" or $tipo=="image/gif" or $tipo=="image/png" or $tipo=="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
        //Ahora podemos subir la imagen al servidor
        switch ($tipo) {
            case 'application/pdf':
                $ext=".pdf";
                break;
            case 'image/jpeg':
                $ext=".jpg";
                break;
            case 'image/jpg':
                $ext=".jpg";
                break;
            case 'image/gif':
                $ext=".gif";
                break;
            case 'image/png':
                $ext=".png";
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $ext=".docx";
                break;
        }

        //Renombrando archivo ..
        //$nombre_archivo = str_replace(" ","_",$nombre_archivo);

        //generamos el randon
        $randon="";
        for ($i=0; $i<15; $i++) {
            $d=rand(1,30)%2;
            $caracter=($d ? chr(rand(65,90)) : chr(rand(48,57)));
            $randon=$randon.$caracter;
        }

        $nombre_archivo = $randon.$ext;
        //Subiendo archivo ..
        copy($temp,"../upload/$carpeta/$nombre_archivo");

    }else {

        $nombre_archivo = " ";

    }

    //Return campo
    return $nombre_archivo;

}

//Funcion que Muestra Url . .
function f_r_url($url, $descripcion, $ayuda) {
    ?>
<a href="<?php echo $url?>" title=".: <?php echo $ayuda?> :."><?php echo $descripcion?></a>
    <?php
}

//Funcion que Muestra Url Vertical. .
function f_r_url_vert($url, $descripcion, $ayuda) {
    ?>
<a href="<?php echo $url?>" title=".: <?php echo $ayuda?> :."><?php echo $descripcion?></a>
    <?php
}

//Funcin mostrar url hija . .
function f_r_url_hija($url, $descripcion, $ayuda) {
    ?>
<a href="<?php echo $url?>" title=".: <?php echo $ayuda?> :." target="_blank"><?php echo $descripcion?></a>
    <?php
}

//Funcion que Muestra Imagen Url . .
function f_r_imagen_url($url, $imagen, $ayuda) {
    ?>
<a href="<? echo $url?>" title=".: <? echo $ayuda?> :."><img src="images/<? echo $imagen?>"/></a>
    <?php
}

// Funcion que Muestra Imagen . .
function f_r_imagen($image, $ext, $alt, $alto, $ancho) {
    echo "<image src=\"images/$image".".$ext\" alt=\"$alt\" border=0 height = $alto width = $ancho>  ";
}

// Fecha Capturada .
function f_r_fecha() {
    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $year_now = date ("Y");
    $month_now = date ("n");
    $day_now = date ("j");
    $week_day_now = date ("w");
    $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " del " . $year_now;
    return $date;
}

// Fecha Capturada .
function f_r_diasemana($fecha) {
    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
    $diaSemana = $week_days[date('N', strtotime($fecha))];
    return $diaSemana;
}

// Funcion que Corta Cadena ..
function f_r_corta_cadena($texto) {
    $tamano = 252; // tamao maximo
    $textoFinal = ''; // Resultado

    // Si el numero de carateres del texto es menor que el tamaño maximo,
    // el tamaño maximo pasa a ser el del texto
    if (strlen($texto) < $tamano) $tamano = strlen($texto);

    for ($i=0; $i <= $tamano - 1; $i++) {
        // Añadimos uno por uno cada caracter del texto
        // original al texto final, habiendo puesto
        // como limite la variable $tamano
        $textoFinal .= $texto[$i];
    }
	$textoFinal = $textoFinal."...";
    // devolvemos el texto final
    return $textoFinal;
}

function f_get_edad($fecha_nacimiento){
    $dia=date("d");
    $mes=date("m");
    $ano=date("Y");
    $dianaz=date("d",strtotime($fecha_nacimiento));
    $mesnaz=date("m",strtotime($fecha_nacimiento));
    $anonaz=date("Y",strtotime($fecha_nacimiento));

    //si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
    if (($mesnaz == $mes) && ($dianaz > $dia)) {
    $ano=($ano-1); }
    
    //si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
    if ($mesnaz > $mes) {
    $ano=($ano-1);}
    
     //ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad   
    $edad=($ano-$anonaz);    
    
    return $edad; 
    
}

?>
