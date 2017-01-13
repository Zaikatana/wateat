<?php
	include 'init.php';
	if ($_SERVER['HTTPS'] != "on") {
		$url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		header("Location: $url");
		exit;
	}
?>
<html>
	<head>
		<title>WatEat?</title>
		<?php
			include 'style.php';
		?>
		<script>
			if(navigator.geolocation){
				navigator.geolocation.getCurrentPosition(setPosition, displayError);
			}
			else{
				alert("Your Browser does not support Location services!");
			}
			function setPosition(position){
				document.getElementById("latitude").value = position.coords.latitude;
				document.getElementById("longitude").value = position.coords.longitude;
			}
			function displayError(error){
				switch(error.code){
					case error.PERMISSION_DENIED:
						alert("Please turn on Location services to use this webapp!");
						break;
				}
			}
		</script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div id="test"></div>
		<div class="container">
			<center><h2>WatEat?</h2><h6>version 0.75</h6></center>
			<form action="controller.php" method="GET">
				<input type="hidden" name="action" value="index">
				<input type="hidden" id="latitude" name="latitude">
				<input type="hidden" id="longitude" name="longitude">
				<div class="form-group">
					<label for="cuisine">Cuisine</label>
					<select class="form-control" id="cuisine" name="cuisine">
						<option value="0">Any</option>
						<?php
							foreach($_SESSION['cuisine'] as $x => $y){
								echo "<option value='$y'>$x</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="radius">Radius (m)</label>
					<input class="form-control" type="number" name="radius" id="radius">
				</div>
				<div class="form-group">
					<label class="switch" for="mode">Student Mode</label>
					&nbsp; <input type="checkbox" id="mode" name="mode">
					<div class="slider round"></div>
				</div>
				<button class="btn btn-default" type="submit" name="button" value="list">Get List</button>
				<button class="btn btn-primary" type="submit" name="button" value="random">Random</button>
			</form>
			<center><h6>Developed by Brian Luc. Powered by Zomato API.</h6></center>
		</div>
	</body>
</html>