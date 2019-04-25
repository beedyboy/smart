<?php
/**
* 
*/
class Controller extends Cmt
{
	protected $_controller, $_action;
	public $view, $validate;

	public function __construct($controller, $action)
	{
		# code...
		parent::__construct();
		$this->_controller = $controller;
		$this->_action = $action;

		$this->view  = new View();
		$this->validate  = new Validate(); 
		
		
  	header('Access-Control-Allow-Origin: *');
  	header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
  	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
 	   header("Content-type: application/json");
	}

	protected function load_model($model)
	{
		//$model =  Pluralizer::plural($model);
		// dnd($model);
		if(class_exists($model))
		{
			$this->{$model} = new $model(strtolower($model));
		
		}
		else{
			die("This model  $model does not exist");

		}
	}
}
