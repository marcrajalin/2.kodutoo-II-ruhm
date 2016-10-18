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
	
	if ( isset($_POST["problem"]) && 
		isset($_POST["wheretosend"]) && 
		!empty($_POST["problem"]) && 
		!empty($_POST["wheretosend"])
	  ) {
		  
		  $new_date = date('Y-m-d', strtotime($_POST['date']));
		  echo "tere";
		savecars($_POST["problem"], $_POST["wheretosend"], $new_date);
		
	}
	//saan köik auto andmed
	$carData = getALLCars();
	echo "<pre>";
	//var_dump($carData);
	echo "</pre>";

?>
<h1>Lahenda auto probleemid</h1>

<p>

	Tere tulemast <?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi välja</a>

</p>

<h2>Palun sisestage all olevad väljad</h2>
<form method="POST">
	
	<label>Mis probleem on teie autoga? Kirjuta enda Email lõpus.</label><br>
	<input name="problem" type="text">
	<br><br>
	
	<label>Kust tahaksid pakkumisi?</label><br>
	<input type="text" name="wheretosend" >
	<br><br>
	
	<label>Sisesta tänane kuupäev</label><br>
	<input type="date" name="date" >
	<br><br>
	
	<input type="submit" value="Salvesta">
	
	
</form>

<h2>Tahaks pakkumist</h2>

<?php
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>"; 
		$html .= "<th>Mis on probleemiks</th>"; 
		$html .= "<th>Kust tahaksid pakkumist</th>"; 
		$html .= "<th>Millal küsitud</th>"; 
	$html .="</tr>";
	
	//iga liikme kohta massiivis
	foreach($carData as $c){
		//iga auto on $c
		//echo $c->problem. "<br>";
		
	$html .="<tr>";
		$html .="<td>".$c->id."</td>";
		$html .="<td>".$c->problem."</td>";
		$html .="<td>". $c->carColor."</td>";
		$html .="<td>". $c->date."</td>";
	$html .="</tr>";
		
	}
	
	$html .= "</table>";
	
	echo $html;
	
	/*$listHtml = "<br><br>";
	
	foreach($carData as $c){
		
		$listHtml .= "<h1 style='color:".$c->carColor."'>".$c->problem."</h1>";
	}
	
	echo $listHtml;*/

?>