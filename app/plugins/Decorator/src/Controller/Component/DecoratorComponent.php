<?php
namespace Decorator\Controller\Component;

use Cake\Controller\Component;

class DecoratorComponent extends Component
{
/**
	 * startup 
	 * 
	 * @param mixed $controller 
	 * @access public
	 * @return void
	 */
	public function startup(&$controller) {
		if (
			!array_key_exists("Decorator.Decorator", $controller->helpers) &&
			array_search("Decorator.Decorator", $controller->helpers) === false
		) {
			$controller->helpers[] = "Decorator.Decorator";
		}
	}
	/**
	 * create 
	 * 
	 * @param mixed $name 
	 * @param array $data 
	 * @access public
	 * @return void
	 */
	public function create($name, $data = array(), $parse = true) {
		return DecoratorFactory::create($name, $data, $parse);
	}
	/**
	 * build 
	 * 
	 * @param mixed $name 
	 * @param array $data 
	 * @access public
	 * @return void
	 */
	public function build($name, $data = array(), $parse = true) {
		return DecoratorFactory::build($name, $data, $parse);
	}

}
