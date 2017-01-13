<!DOCTYPE html>
<html>
	<head>
		<?php
			include 'style.php';
			include 'init.php';
		?>
		<style>
		#map {
			height:400px;
			weight:100%;
		}
		</style>
		<title>WatEat?</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="container">
		<center><h2>WatEat?</h2><h6>version 0.75</h6></center>
		<div id="map"></div>
		<script>
			var map;
			function initMap(){
				map = new google.maps.Map(document.getElementById('map'), {
					center: {
						lat: <?php echo $_SESSION['lat']; ?>,
						lng: <?php echo $_SESSION['lon']; ?>	
					},
					zoom: <?php echo $_SESSION['scale']; ?>
				});
				var curr = new google.maps.Circle({
					strokeColor: 'white',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: 'blue',
					fillOpacity: 0.35,
					map: map,
					center: {
						lat: <?php echo $_SESSION['lat']; ?>,
						lng: <?php echo $_SESSION['lon']; ?>
					},
					radius: <?php echo $_SESSION['radius']; ?>
				});
				<?php
					$c = 0;
					foreach($_SESSION['result'] as $x){
						$variable = "marker".$c;
						echo "var $variable = new google.maps.Marker({
							position: {lat: $x->lat,
							lng: $x->lon},
							map: map
						});\n";
						$c++;
					}
				?>
			}
		</script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFDGOL8QRoEanjxGJpEqhGRteydPfaQtg&callback=initMap"></script>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr>
					<!--td>Image</td-->
					<td>Name</td>
					<td>Address</td>
					<td>Cuisine</td>
					<td>Rating</td>
					<td>Average Cost for 2</td>
				</tr>
				<?php
					$count = count($_SESSION['result']);
					if($count != 0){
						foreach($_SESSION['result'] as $x){
							//echo "<tr><td><img src='$x->image' style='width:40%;height:40%'></td>";
							echo "<tr><td><a data-toggle='modal' data-target='#$x->id'>$x->name</a></td>";
							echo "<td>$x->address</td>";
							echo "<td>$x->cuisine</td>";
							echo "<td>$x->rating</td>";
							echo "<td>$x->avgcost</td></tr>";
						}
					}
					else{
						echo "<tr><td colspan=100%>No restaurants to show!</td></tr>";
					}
				?>
			</table>
		</div>
		<?php
			foreach($_SESSION['result'] as $x){
				echo "
					<div class='modal fade' id='$x->id' tabindex='-1' role='dialog' aria-labelledby='label$x->id'>
						<div class='modal-dialog' role='document'>
							<div class='modal-content'>
								<div class='modal-header'>
									<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times</span></button>
									<h4 class='modal-title' id='label$x->id'>$x->name</h4>
								</div>
								<div class='modal-body'>
									<img src='$x->image' class='img-responsive'>
									<hr>
									<label>Address: </label>&nbsp$x->address<br/>
									<label>Rating: </label>&nbsp$x->rating<br/>
									<label>Average Cost: </label>&nbsp$x->avgcost<br/>
									<label>Cuisines: </label>&nbsp$x->cuisine<br/>
									<label>Menu URL: </label>&nbsp<a href='$x->menu' target='_blank'>Link</a><br/>
									<label>Photo URL: </label>&nbsp<a href='$x->photos' target='_blank'>Link</a><br/>
								</div>
								<div class='modal-footer'>
									<button type='button' class='btn btn-primary' data-dismiss='modal'>Close</button>
								</div>
							</div>
						</div>
					</div>
				";
			}
		?>
		<form action="controller.php" method="GET">
			<input type="hidden" name="action" value="result">
			<center><button class="btn btn-primary" type="submit">Go Back</button></center>
		</form>
		<center><h6>Developed by Brian Luc. Powered by Zomato API.</h6></center>
		</div>
	</body>
</html>