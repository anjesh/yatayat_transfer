<?
function getRoutesDataFromAPI() {
	$routes = array(
		104 => array(
			"ref" => "14A",
			"stops" => array(
				1=>"A",
				2=>"B",
				3=>"C",
				4=>"D",
				5=>"E",
			)
		),
		105=> array(
			"ref" => "15A",
			"stops"=>array(
				5=>"E",
				6=>"G",
				7=>"H",
				8=>"I",
				9=>"J",
			)
		),
		106 => array(
			"ref"=>"14A",
			"stops"=>array(
				9=>"J",
				10=>"K",
				11=>"L",
				12=>"M",
				13=>"N",
			)
		),
		107 => array(
			"ref"=>"17",
			"stops"=>array(
				4=>"J",
				14=>"K",
				15=>"L",
			)
		),
	);
	return $routes;
}

$routes = getRoutesDataFromAPI();
include_once('routes.php');

$locfrom_id=9;
$locto_id=14;
$routefrom_ids = getRoutes($locfrom_id);
$routeto_ids = getRoutes($locto_id);

print("locfrom Routes:");
print_r($routefrom_ids);
print("locto Routes:");
print_r($routeto_ids);

print_R(getTransferPoints($routefrom_ids[0], $routeto_ids[0]));

print_R(getInBetweenRoutes($routefrom_ids[0], $routeto_ids[0]));

print("Low cost stop points between $locfrom_id and $locto_id:");
print_r(getLowcostStopPoints($locfrom_id, $locto_id));

//getStopPoints($locfrom_id, getInBetweenRoutes(getRoutes($locfrom_id), getRoutes($locto_id)), $locto_id)

/*

if(array_intersect($routefrom_ids, $routeto_ids)) {
	$stoppoints = array($locfrom_id, $locto_id);	
} else {
	if(count($routefrom_ids) != count($routeto_ids)) {
		foreach($routefrom_ids as $routefrom_id) {
			foreach($routeto_ids as $routeto_id) {
				$stoppoints[] = getStopPoints($locfrom_id, getInBetweenRoutes($routefrom_id, $routeto_id), $locto_id);				
			}			
		}
	}
}

print_R($stoppoints);
*/

/*
print_R($stoppoints);
sort($stoppoints);
print_R($stoppoints);

print_r($routefrom_ids);
print_r($routeto_ids);

print_r(getInBetweenRoutes(104,106));

print_r(getTransferPoints(104,105));

print_r(getTransferPoints(105,106));

*/
/*
$stoppoints = getStopPoints(array(104,105,106));
$stoppoints[0] = $locfrom_id;
$stoppoints[count($stoppoints)] = $locto_id;
print_R($stoppoints);
sort($stoppoints);
print_R($stoppoints);
*/