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

//realizamos la conexión a la base de datos
$objCon = new Connection();
$objCon->get_connected();

//consultamos el listado de los usuarios!!
$objUse = new Users();
$list_users = $objUse->list_users();

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Modulo de Usuarios!!</title>
    </head>
    
    <body>
    	
        <?php echo "Bienvenido, " . $_SESSION['user'];?>
        
        <?php require'../global/menu.php';?>
        
        <table align="center" border="1">
        	
            <thead>
            	<tr><td colspan="5" align="center"><a href="new_user.php">Nuevo Usuario</a></td></tr>
                <tr><th colspan="5" align="center">Listado de Usuarios!!!</th></tr>
                <tr><td>Nombre de Usuario</td><td>Perfil</td><td colspan="2" align="center">Acciones</td></tr>
                
            </thead>
            <tbody>
            
            	<?php
        	
				$numrows = mysql_num_rows($list_users);
				
				if($numrows > 0){
					
					while($row=mysql_fetch_array($list_users)){?>
                    
                    	<tr>
                        	<td><?php echo $row["loginUsers"];?></td>
                            <td><?php echo $row["nameProfi"]; ?></td>
                            <td><a href="assign_role.php?idUser=<?php echo $row["idUsers"];?>">Roles</a></td>
                            <td><a href="modify_user.php?idUser=<?php echo $row["idUsers"];?>">Modificar</a></td>
							<td><a href="delete_user.php?idUser=<?php echo $row["idUsers"];?>">Eliminar</a></td>
                        </tr>
                        
						<?php
					}
					
				}
			
				?>
            
            </tbody>
        
        </table>
        
    </body>
</html>