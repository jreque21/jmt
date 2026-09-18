<?php

function f_seccion_pie() {
    
	// Instanciar clase de la B.D
    $crud = new crud();

    // Definir estructura
    $array_campo_pk	= array('V_ID');
    $array_valor_pk	= array('1');

    // Recuperar info
    $t_url_facebook	= $crud->fila_recuperar_campo('MAE_EMPRESA', $array_campo_pk, $array_valor_pk, 'V_URL_FB');
    $t_url_twitter 	= $crud->fila_recuperar_campo('MAE_EMPRESA', $array_campo_pk, $array_valor_pk, 'V_URL_TW');
    $t_url_youtube 	= $crud->fila_recuperar_campo('MAE_EMPRESA', $array_campo_pk, $array_valor_pk, 'V_URL_YT');

    ?>
    <footer class="footer-corporate bg-gray-darkest">
    <div class="container">
    <div class="footer-corporate__inner">
        
        <p class="rights">
            Copyright &copy; <?php echo COPYRIGHT ?> <a href="<?php echo COPYRIGHT_WEB ?>" target="_blank"><?php echo COPYRIGHT_AUTOR ?></a>. Todos los derechos reservados.
        </p>
        <ul class="list-inline-xxs">
        <li><a class="icon icon-xxs icon-gray-darker fa fa-facebook" href="<?php echo $t_url_facebook?>" target="_blank"></a></li>
        <li><a class="icon icon-xxs icon-gray-darker fa fa-twitter" href="<?php echo $t_url_twitter;?>" target="_blank"></a></li>
        <li><a class="icon icon-xxs icon-gray-darker fa fa-youtube" href="<?php echo $t_url_youtube;?>" target="_blank"></a></li>
        </ul>
    </div>
    </div>
    </footer>    
<?php
}  

// Carga Fin
function f_close_pagina(){
?>
<!-- Global Mailform Output-->
<div class="snackbars" id="form-output-global"></div>
    <!--+photoswipe()-->
    <!-- Javascript-->
    <script src="../js/core.min.js"></script>
    <script src="../js/script.js"></script>
    <!-- coded by Houdini-->
  </body>
</html>
<?php
}