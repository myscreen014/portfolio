<?php

/* log shortcut */
function varlog($var) {
	error_log(print_r($var, true));
}

function route_page($page, $params=array()) {
	$routeParams = array();
	array_push($routeParams, $page->slug);
	array_push($routeParams, implode('/', $params));
	return route('page', $routeParams);
}



