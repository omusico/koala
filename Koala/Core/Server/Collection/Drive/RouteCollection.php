<?php
namespace Server\Collection\Drive;
use Server\Route\Drive\Route;
use Server\Collection\DataCollection;
final class RouteCollection extends DataCollection{
	public function set($key, $value){
        if (!$value instanceof Route) {
            $value = new Route($value);
        }
        return parent::set($key, $value);
    }
	public function add($route){
		if (!$route instanceof Route) {
            $route = new Route();
        }
        return $this->addRoute($route);
	}
	public function addRoute(Route $route){
        $name = spl_object_hash($route);
        return $this->set($name, $route);
    }
}