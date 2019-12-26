<?php

//Inicio del menu!!
echo '<ul>';

//La opcion Inicio va estar presente en todos los perfiles!!!
echo '<li><a href="index.php">Inicio</a></li>';

//Verificamos el perfil para determinar que partes del menu podrá ver
if($_SESSION['idprofile']==2){
	echo '<li><a href="user_list.php">Usuarios</a></li>
		<li><a href="profile_list.php">Perfiles</a></li>
		<li><a href="module_list.php">Modulos</a></li>
		<li><a href="role_list.php">Roles</a></li>';
}


//El logout va a estar presente en todos los perfiles!!!
echo '<li><a href="log_out.php">Salir</a></li>';
//fin del menu
echo '</ul>';

?>