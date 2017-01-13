<?php
	session_start();
	class RestaurantObject{
		var $id;
		var $name;
		var $address;
		var $cuisine;
		var $avgcost;
		var $rating;
		var $image;
		var $lat;
		var $lon;
		var $menu;
		var $photos;
		
		function setId($par){
			$this->id = $par;
		}
		function setName($par){
			$this->name = $par;
		}
		function setAddress($par){
			$this->address = $par;
		}
		function setCuisine($par){
			$this->cuisine = $par;
		}
		function setAvgCost($par){
			$this->avgcost = $par;
		}
		function setRating($par){
			$this->rating = $par;
		}
		function setImage($par){
			$this->image = $par;
		}
		function setLat($par){
			$this->lat = $par;
		}
		function setLon($par){
			$this->lon = $par;
		}
		function setMenu($par){
			$this->menu = $par;
		}
		function setPhotos($par){
			$this->photos = $par;
		}
	}
	if(!isset($_SESSION['cuisine'])){
		$json = fopen("cuisineID.json","r");
		$buffer = fread($json,filesize("cuisineID.json"));
		fclose($json);
		$a = json_decode($buffer,true);
		$b = array();
		foreach($a['cuisines'] as &$i){
			$b[$i[cuisine][cuisine_name]] = $i[cuisine][cuisine_id];
		}
		$_SESSION['cuisine'] = $b;
	}
?>