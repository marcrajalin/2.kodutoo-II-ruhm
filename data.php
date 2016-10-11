<?php
	require("functions.php");
	//kui ei ole kasutaja id
	if (isset($_SESSION["userId"])) {
		
		//suunan sisselogimise lehele
		header("Locatation: login.php");
		
		//suunan sisselogimise lehele
		//exit();
		
	}
	
	//kui on ?logout adressireal siis login väja
	if(isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
	
	}

	if ( isset($_POST["plate"]) && 
		isset($_POST["color"]) && 
		!empty($_POST["plate"]) && 
		!empty($_POST["color"])
	  ) {
		  
		saveauto(cleanInput($_POST["plate"], $_POST["color"]));
		
	}
	//saan köik auto andmed
	$carData = getALLCars();
	echo "<pre>";
	var_dump($carData);
	echo "</pre>";

?>
<h1>Data</h1>

<p>

	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>

</p>

<h2>Salvesta auto</h2>
<form method="POST">
	
	<label>Auto nr</label><br>
	<input name="plate" type="text">
	<br><br>
	
	<label>Auto värv</label><br>
	<input type="color" name="color" >
	<br><br>
	
	<input type="submit" value="Salvesta">
	
	
</form>

<h2>Autod</h2>

<?php
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>plate</th>";
		$html .= "<th>color</th>";
	$html .="</tr>";
	
	//iga liikme kohta massiivis
	foreach($carData as $c){
		//iga auto on $c
		//echo $c->plate. "<br>";
		
	$html .="<tr>";
		$html .="<td>".$c->id."</td>";
		$html .="<td>".$c->plate."</td>";
		$html .="<td style='background-color:".$c->carColor."'>".$c->carColor."</td>";
	$html .="</tr>";
		
	}
	
	$html .= "</table>";
	
	echo $html;
	
	$listHtml = "<br><br>";
	
	foreach($carData as $c){
		
		$listHtml .= "<h1 style='color:".$c->carColor."'>".$c->plate."</h1>";
	}
	
	echo $listHtml;

?>