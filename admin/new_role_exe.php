<?php

require'../class/sessions.php';
$objses = new Sessions();
$objses->init();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : null ;

if($user == ''){
	header('Location: http://localhost:8888/CodigosVideos/3-AsignandoPerfiles/index.php?error=2');
}

?>
<?php

//Llamado de los archivos clase
require'../class/config.php';
require'../class/users.php';
require'../class/dbactions.php';
require'../class/roles.php';
require'../class/modules.php';


//realizamos la conexión a la base de datos
$objCon = new Connection();
$objCon->get_connected();

$objRole = new Roles();

$objRole->new_role();

header('Location: role_list.php');

?>