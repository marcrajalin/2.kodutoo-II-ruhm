<?php
	
	
	require("../../config.php");
	// functions.php
	//var_dump($GLOBALS);
	// see fail, peab olema kõigil lehtedel kus tahan kasutada session muutujat.
	session_start(); 
	//***************
	//**** SIGNUP ***
	//***************
	
	
	function signUp ($email, $password) {
		
		$database = "if16_marcraja_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	function login ($email, $password) {
		
		$error = "";
		
		$database = "if16_marcraja_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("
		SELECT id, email, password, created 
		FROM user_sample
		WHERE email = ?");
	
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		
		//andmed tulid andmebaasist või mitte
		// on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			
		
			
			if ($hash == $passwordFromDb) {
				echo "Kasutaja logis sisse ".$id;
				
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				
				
				
				header("Location: data.php");
				
			}else {
				$error = "vale parool";
			}
		
			
		} else {
			
			
			// ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
		return $error;
	}
	
	
	
	function savecars ($problem, $wheretosend, $date) {
		
		$database = "if16_marcraja_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO korjattava (problem, wheretosend, date) VALUES (?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("sss", $problem, $wheretosend, $date);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
		
	function getALLCars() {
		$database = "if16_marcraja_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("
			SELECT id, problem, wheretosend, date
			FROM korjattava
		");
		echo $mysqli->error;
		
		$stmt->bind_result($id, $problem, $wheretosend, $date);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		while ($stmt->fetch()) {
			
			//tekitan objekti
			$car = new StdClass();
			$car->id = $id;
			$car->problem = $problem;
			$car->carColor = $wheretosend;
			$car->date = $date;
			
			
			//echo $problem."<br>";
			//iga kord massiivi lisan juurde nr märgi
			array_push ($result, $car);
		} 
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	
		
	}
		
		
	
	function cleanInput($input) {
		$input = trim($input);
		//$input = stripcslashes($input);
		$input = htmlspecialchars($input);
		
		return $input;
		
		
		
		
		
		
		
	}

?>