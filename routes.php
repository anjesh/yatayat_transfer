<?

//Get route id of the route which contains location id
//may return multiple route ids if the location is present in both the routes, in the case of transfer points
function getRoutes($locid) {
	global $routes;
	$found_routes_ids = array();
	foreach($routes as $route_id=>$route_data) {
		if(array_key_exists($locid, $route_data['stops'])) {
			$found_routes_ids[] = $route_id;
		}
	}
	return $found_routes_ids;
}

//return the transfer points between two routes
function getTransferPoints($route1_id, $route2_id) {
	global $routes;	
	$common_routes_ids = array_intersect_key($routes[$route1_id]['stops'], $routes[$route2_id]['stops']);
	return ((count($common_routes_ids)>=1)?$common_routes_ids:false);
}

//return the array of routes if there's a different route in between for the transfer
//works for only 3 sets of routes 
//@TODO need to extend this to work for any number of inbetween routes 
function getInBetweenRoutes($route1_id, $route2_id) {
	global $routes;	
	if($route1_id == $route2_id) {
		return array($route1_id);
	}
	if(getTransferPoints($route1_id, $route2_id)) {
		return array($route1_id, $route2_id);
	}
	foreach($routes as $route_id=>$route_data) {
		if(false == in_array($route_id, array($route1_id, $route2_id))) {
			if(getTransferPoints($route_id, $route1_id) && getTransferPoints($route_id, $route2_id)) {
				return array($route1_id, $route_id, $route2_id);
			}
		}
	}
}

//get stop points where one has to change the route
//@TODO get all the possible set of stop points (to be used for cost calculation)
function getStopPoints($locfrom_id, $via_route_ids, $locto_id) {
	$stop_ids[0] = $locfrom_id;
	for($i=0;$i<count($via_route_ids)-1;$i++) {
		 $tmp_point = getTransferPoints($via_route_ids[$i], $via_route_ids[$i+1]);
		 $stop_ids[$i+1] = key($tmp_point);
	}
	$stop_ids[] = $locto_id;
	return $stop_ids;
}

//main function that returns the low cost stop points
//@TODO should contain the cost calculation function of stop points
function getLowcostStopPoints($locfrom_id, $locto_id) {
	$routefrom_ids = getRoutes($locfrom_id);
	$routeto_ids = getRoutes($locto_id);

	if(array_intersect($routefrom_ids, $routeto_ids)) {
		$stoppoints = array($locfrom_id, $locto_id);	
	} else {
		foreach($routefrom_ids as $routefrom_id) {
			foreach($routeto_ids as $routeto_id) {
				$stoppoints[] = getStopPoints($locfrom_id, getInBetweenRoutes($routefrom_id, $routeto_id), $locto_id);				
			}			
		}
	}	
	return $stoppoints;
}





