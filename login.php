<?php 
	
	require("functions.php");
	
	//echo hash("sha512", "b");
	
	IF (isset($_SESSION["userId"])) {
		
		//suunan sisselogimise lehele
		header("Locatation: login.php");
	}
	
	//GET ja POSTi muutujad
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//echo strlen("äö");
	
	// MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$signupmobilenumberError = "";
	$error = "";
	
	// on üldse olemas selline muutja
	if( isset( $_POST["signupEmail"] ) ){
		
		//jah on olemas
		//kas on tühi
		if( empty( $_POST["signupEmail"] ) ){
			
			$signupEmailError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik";
			
		} else {
			
			// siia jõuan siis kui parool oli olemas - isset
			// parool ei olnud tühi -empty
			
			// kas parooli pikkus on väiksem kui 8 
			if ( strlen($_POST["signupPassword"]) < 4 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 4 tähemärkki pikk";
			
			}
			
		}
		
	}
	
	if (isset ($_POST["signupmobilenumber"])) {
	
	//oli olemas, ehk keegi vajutas nuppu
	//kas oli tühi
	if (empty ($_POST["signupmobilenumber"])) {
		$signupmobilenumber = "See väli on kohustuslik";
	//echo "telefon number oli tühi";	
		
	}
	}
	
	
	// peab olema email ja parool
	// ühtegi errorit
	
	if ( isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) && 
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
		) {
		
		// salvestame ab'i
		echo "Salvestan... <br>";
		
		echo "email: ".$signupEmail."<br>";
		echo "password: ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "password hashed: ".$password."<br>";
		
		
		//echo $serverUsername;
		
		// KASUTAN FUNKTSIOONI
		signUp(cleanInput($signupEmail,$password ));
		
	
	}
	
	
	
	if (isset($_POST["loginEmail"]) && isset ($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"]))
		{
			
			$error = login($_POST["loginEmail"], $_POST["loginPassword"]);
		}
		
		
		
	
?>



<!DOCTYPE html>
<html>
<head>
	<title>Logi sisse või loo kasutaja</title>
</head>
<body>

	<h1>Logi sisse</h1>
	<form method="POST">
		<p style="color:red;"><?=$error;?></p>
		<label>E-post</label>
		<br>
		
		<input name="loginEmail" type="text">
		<br><br>
		
		<input type="password" name="loginPassword" placeholder="Parool">
		<br><br>
		
		<input type="submit" value="Logi sisse"> 
		
		<br><br>
		
		
		
	</form>
	
	
	<h1>Loo kasutaja</h1>
	<form method="POST">
		
		
		
		
		<br>
		<label>E-post</label>
		<br>
		
		<input name="signupEmail" type="text" value="<?=$signupEmail;?>"> <?=$signupEmailError;?>
		<br>
		
		<br>
		<input type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError; ?>
		<br><br>
		
		<label>Mobilenumber</label> <br>
 
		<input name="loginmobile" type="mobile"> <?php echo $signupmobilenumberError ?> <br><br>
		
		<input type="submit" value="Loo kasutaja">
		
		
	</form>

</body>
</html>

