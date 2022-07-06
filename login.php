<?php
	session_start();
	if (isset($_SESSION['email'])){
		header("Location: panel.php");
	}
	include 'credenciales.php';
	$msg="";
	if(isset($_GET['btn'])){
		$email = $_GET['email'];
		$pass = $_GET['password'];
		if($email=="admin@server.com" && $pass=="serveradmin"){
			$msg="Bienvenido";
			session_start();
			$_SESSION['email']="admin@server.com";
			$_SESSION['password']="serveradmin";
			header("Location: paneladmin.php");
		}
		$con = mysqli_connect(HOST,USER,PASS,DB);
		$ssql="SELECT * FROM usuarios";
		$response= mysqli_query($con,$ssql);
		if(mysqli_num_rows($response)>0){
			while($fila=mysqli_fetch_array($response,MYSQLI_ASSOC)){
				//var_dump($fila);
				if ($fila["email"]==$email && $fila["password"]==$pass){
					$msg="Bienvenido";
					session_start();
					$_SESSION['idUsuario']=$fila['idUsuario'];
					$_SESSION['email']=$email;
					$_SESSION['password']=$password;
					header("Location: panel.php");
				}else{
					$msg="Usuario o contraseña incorrectos";
				}
			}
		}else{
			$msg="No hay usuarios en la base de datos, registrate y vuelve a intentar";
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<title>Web generator FM</title>
</head>
<body>
	<center>
		<h1>Webgenerator Fausto Martínez</h1>
		<h2>Ingresá</h2>
		<form method="GET">
			<input type="text" name="email" placeholder="Email">
			<input type="password" name="password" placeholder="Contraseña">
			<input type="submit" name="btn" value="Ingresar">
		</form>
		Todavía no tienes una cuenta? Prueba <a href="register.php"> registrarte </a>
		<div>
		<?php
			echo $msg;
		?>
	</div>
	</center>
</body>
</html>