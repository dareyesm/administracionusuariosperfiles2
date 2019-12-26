<?php

class Users{
	
	public $objDb;
	public $objSe;
	public $result;
	public $rows;
	public $useropc;
	
	public function __construct(){
		
		$this->objDb = new Database();
		$this->objSe = new Sessions();
		
	}
	
	public function login_in(){
		// para el inicio de sesion de los usuarios!!
		$query = "SELECT * FROM users, profiles WHERE users.loginUsers = '".$_POST["usern"]."' 
			AND users.passUsers = '".$_POST["passwd"]."' AND users.idprofile = profiles.idProfile ";
		$this->result = $this->objDb->select($query);
		$this->rows = mysql_num_rows($this->result);
		if($this->rows > 0){
			
			if($row=mysql_fetch_array($this->result)){
				
				$this->objSe->init();
				$this->objSe->set('user', $row["loginUsers"]);
				$this->objSe->set('iduser', $row["idUsers"]);
				$this->objSe->set('idprofile', $row["idprofile"]);
				
				$this->useropc = $row["nameProfi"];
				
				switch($this->useropc){
					
					case 'Standard':
						header('Location: user/index.php');
						break;
						
					case 'Admin':
						header('Location: admin/index.php');
						break;
					
				}
				
			}
			
		}else{
			
			header('Location: index.php?error=1');
			
		}
		
	}
	
	public function list_users(){
		
		//realizamos la busqueda en la bd de todos lo usuarios registrados
		$query = "SELECT * FROM users, profiles WHERE users.idprofile = profiles.idProfile 
			ORDER BY users.idUsers ASC";
		$this->result = $this->objDb->select($query);
		return $this->result;
		
	}
	
	public function single_user($idUser){
		
		//realizamos la busqueda del usuario a modificar
		$query = "SELECT * FROM users, profiles WHERE users.idUsers = '".$idUser."' 
			AND users.idprofile = profiles.idProfile ";
		$this->result = $this->objDb->select($query);
		return $this->result;
		
	}
	
	public function new_user(){
		
		//En esta seccion insertamos el usuario en la tabla users!!!
		//$query = "INSERT INTO users VALUES(default, '".$_POST["login"]."', '".$_POST["pass"]."', 
		//	'".$_POST["profile"]."', '".$_POST["email"]."', '1', 'images', '".$_POST["status"]."', '1')";
		$query = "INSERT INTO users VALUES(default, '".$_POST["login"]."', '".$_POST["pass"]."', 
			'".$_POST["profile"]."', '".$_POST["email"]."', '1', 'images', '1')";
		$this->objDb->insert($query);
		
		//Obtenemos el ID del Ultimo usuario ingresado a la tabla users!!
		$query = "SELECT * FROM users ORDER BY idUsers DESC Limit 1";
		$result = $this->objDb->select($query);
		if($pro=mysql_fetch_array($result)){
			$idUser = $pro["idUsers"];
		}
		
		$query = "SELECT * FROM profiles";
		$this->result = $this->objDb->select($query);
		while($row=mysql_fetch_array($this->result)){
			//estoy armando el nombre de la variable POST
			$namePro = "pro" . $row["idProfile"];
			
			if(isset($_POST[$namePro])){
				mysql_query("INSERT INTO user_pro VALUES(default, '".$row["idProfile"]."', '".$idUser."')");
			}
		}
		
	}
	
	public function modify_user(){
		
		$query = "UPDATE users SET loginUsers = '".$_POST["login"]."', passUsers = '".$_POST["pass"]."', 
			idprofile = '".$_POST["profile"]."', emailUser = '".$_POST["email"]."'
			WHERE idUsers = '".$_POST["idUsers"]."' ";
		$this->objDb->update($query);
		
		$query = "DELETE FROM user_pro WHERE idUsers = '".$_POST["idUsers"]."' ";
		$this->objDb->delete($query);
		
		$query = "SELECT * FROM profiles";
		$this->result = $this->objDb->select($query);
		while($row=mysql_fetch_array($this->result)){
			$namePro = "pro" . $row["idProfile"];
			if(isset($_POST[$namePro])){
				mysql_query("INSERT INTO user_pro VALUES(default, '".$row["idProfile"]."', '".$_POST["idUsers"]."')");
			}
		}
		
		
	}
	
	public function delete_user(){
		
		$query = "DELETE FROM users WHERE idUsers = '".$_GET["idUser"]."' ";
		$this->objDb->delete($query);
		$query = "DELETE FROM user_pro WHERE idUsers = '".$_GET["idUser"]."' ";
		$this->objDb->delete($query);
		
	}
	
	public function look_user_profiles(){
		$query = "SELECT * FROM user_pro, mod_profile, roles, modules WHERE user_pro.idUsers = '".$_GET["idUser"]."' 
			AND user_pro.idProfile = mod_profile.idProfile AND mod_profile.idmodule = roles.idmodule 
			AND  roles.idmodule = modules.idmodule ";
		$this->result = $this->objDb->select($query);
		return $this->result;
		
	}
	
}

?>