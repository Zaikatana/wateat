<?php
	include 'init.php';
	function loadRestaurant($r, $x){
		$r->setId($x[id]);
		$r->setName($x[name]);
		$r->setAddress($x[location][address]);
		$r->setCuisine($x[cuisines]);
		$r->setAvgCost($x[average_cost_for_two]);
		$r->setRating($x[user_rating][aggregate_rating]);
		$r->setImage($x[featured_image]);
		$r->setLat($x[location][latitude]);
		$r->setLon($x[location][longitude]);
		$r->setMenu($x[menu_url]);
		$r->setPhotos($x[photos_url]);
	}
	if($_GET['action'] == "index"){
		$cuisine = $_GET['cuisine'];
		$radius = $_GET['radius'];
		$mode = $_GET['mode'];
		$button = $_GET['button'];
		$lat = $_GET['latitude'];
		$lon = $_GET['longitude'];
		$_SESSION['lat'] = $lat;
		$_SESSION['lon'] = $lon;
		$_SESSION['radius'] = $radius;
		if($radius == null){
			if($cuisine=="0"){
				$ch = curl_init("https://developers.zomato.com/api/v2.1/search?count=1000&lat=$lat&lon=$lon&sort=rating&order=desc");
			}
			else{
				$ch = curl_init("https://developers.zomato.com/api/v2.1/search?count=1000&lat=$lat&lon=$lon&cuisines=$cuisine&sort=rating&order=desc");
			}
		}
		else{
			if($cuisine=="0"){
				$ch = curl_init("https://developers.zomato.com/api/v2.1/search?count=1000&lat=$lat&lon=$lon&radius=$radius&sort=rating&order=desc");
			}
			else{
				$ch = curl_init("https://developers.zomato.com/api/v2.1/search?count=1000&lat=$lat&lon=$lon&radius=$radius&cuisines=$cuisine&sort=rating&order=desc");
			}
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('user-key: 7d896b11e84b621384498562cdc345c1'));
		//silences curl output
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl = curl_exec($ch);
		curl_close($ch);
		$a = json_decode($curl,true);
		$result = array();
		if($button == "random"){
			if($mode){
				while(true){
					$rand = rand(0, count($a['restaurants'])-1);
					$x = $a['restaurants'][$rand][restaurant];
					if($x[price_range] < 3){
						$r = new RestaurantObject;
						loadRestaurant($r,$x);
						array_push($result, $r);
						break;
					}
				}
			}
			else{
				$rand = rand(0, count($a['restaurants'])-1);
				$x = $a['restaurants'][$rand][restaurant];
				$r = new RestaurantObject;
				loadRestaurant($r,$x);
				array_push($result, $r);
			}
		}
		else{
			if($mode){
				foreach($a['restaurants'] as $x){
					if($x[restaurant][price_range] < 3){
						$r = new RestaurantObject;
						loadRestaurant($r,$x[restaurant]);
						array_push($result, $r);
					}
				}
			}
			else{
				foreach($a['restaurants'] as $x){
					$r = new RestaurantObject;
					loadRestaurant($r,$x[restaurant]);
					array_push($result, $r);
				}
			}
		}
		$_SESSION["result"] = $result;
		$scale = $_GET['radius'];
		if($scale<=1000){
			$_SESSION['scale'] = 14;
		}
		else if($scale>1000 && $scale<=3500){
			$_SESSION['scale'] = 13;
		}
		else if($scale>3500 && $scale<6500){
			$_SESSION['scale'] = 12;
		}
		else if($scale>=6500){
			$_SESSION['scale'] = 11;
		}
		$redirect = "Location: result.php";
	}
	else if($_GET['action']=="result"){
		unset($_SESSION["result"]);
		$redirect = "Location: index.php";
	}
	header($redirect);
?>