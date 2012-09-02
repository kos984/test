<?php
/*
 * tp - template
 */


/**
 * class Model the base class for all Models
 * @author kos
 * 
 */
class Model{
	public function  __construct(){
		
	}
	/**
	 * params {Array} keys [conditions|fields|order]
	 * $
	 * 
	 * @param array $params
	 * @return array
	 */
	public function find(array $params = array()){ //TODO: documente
		$tablName = '`'.strtolower($this->name).'s`';
	
		$query = 'SELECT ';
		// fields
		if (isset( $params['fields'] )){
			$params['fields'] = str_replace('.','`.`',$params['fields']);
			$query .= '`'.implode("`,`", $params['fields']).'`';
		} else {
			$query .= "*"; //`$this->name`.
		}
		$query .= " FROM  `".strtolower($this->name)."s` AS `$this->name`";
		
		// has Many block
		if (isset ( $this->hasMany ) && count($this->hasMany) > 0 ){
			$tmp = $this->hasMany;
			foreach($tmp as $k => $v){
				if (!isset($v['className'],$v['foreignKey'])){
					throw new Exception('Model error className or foreignKey does not set!');
				}
				
				$className = $v['className'];
				$foreignKey = $v['foreignKey'];
				$query .= " LEFT JOIN `".strtolower($className)."s` AS `$className` ON `$className`.`$foreignKey` = `$this->name`.`id`";
			}
		}
		// belogs To block
		if (isset ( $this->belongsTo ) && count($this->belongsTo) > 0 ){
			$tmp = $this->belongsTo;
			foreach($tmp as $k => $v){
				if (!isset($v['className'],$v['foreignKey'])){
					throw new Exception('Model error className or foreignKey does not set!');
				}
				
				$className = $v['className'];
				$foreignKey = $v['foreignKey'];
				$query .= " LEFT JOIN `".strtolower($className)."s` AS `$className` ON `$className`.`id` = `$this->name`.`$foreignKey`";
			}
		}
		//conditions TODO ...
		//order
		if (isset($params['order']) && count($params['order']) > 0){
			$params['order'] = str_replace('.','`.`',$params['order']);
			$query.= ' ORDER BY `'.implode("`,`", $params['order']).'`';
		}
		$query = mysql_query($query);//'SELECT * FROM  `'.strtolower($this->name).'s` ORDER BY `id`');
		$arr = array();
		for ($i = 0, $n = mysql_num_rows($query); $i <$n; $i++){
			$arr[] = mysql_fetch_assoc($query);	
		}
		return array($this->name=>$arr);
	}
}
//===============================================================
/**
 * class Controller the base class for all Controlers
 * @author kos
 *
 */
class Controller{
	/**
	 * @var {String} layout to output
	 */
	protected $layout = 'default';
	/**
	 * @var {String} title of document
	 */
	protected $title = '';
	/**
	 * array what consist varionbles to use in view
	 * @var {Array}
	 */
	protected $valiables = array();
	
	/**
	 * 
	 * @param $controllerName {String} this value will be set as title of document
	 * @return void
	 */
	public function __construct($controllerName){
		
		// set title of document as default
		$this->title = $controllerName;
		
		// uses section
		// include to controller all Models what uses
		foreach ($this->uses as $v){
			
			$model_f = 'app/Model/'.$v.'.php'; // get path to model
			
			if (!file_exists($model_f)){ // if this modex doe not exist throw Exception
				throw new Exception("Model file does not exist!");
			}
			include '/var/www/teststuzocom/'.$model_f; // include Model
			if (!class_exists($v)){
				throw new Exception('Model class does not exist!');
			}
			
			$tmp = new $v(); // create new object form class $v (extends Models)
			$this->$v = $tmp; // add to Controller new Model object 
			if (!$tmp instanceof Model){ // if $tmp is not extend Model throw Exception
				throw new Exception('error: model '.$v.' is not extends from Model class!');
			}
		}
	}
	
	/**
	 * function render page
	 * @param $view {String} filePath to view; example app/View/Controller/viewName.cp
	 * @return void
	 */
	public function render($view){
		
		// get path to layout tp
		$tp = 'app/View/Layouts/'.$this->layout.'.tp';
		if(!file_exists($tp)){
			throw new Exception('layout does not exist!');
		}
		
		// cheack for exist view.tp
		if(!file_exists($view)){
			throw new Exception('view does not exist!');
		}
		
		// create all variables to use for template what were set in controller
		foreach ($this->valiables as $k => $v){
			$$k = $v;
		}
		
		// generate html from users template and write info $content value
		ob_start();
		include $view;
		$content  =  ob_get_clean();
		ob_end_flush();
		
		
		// set variable title for layout
		$title = $this->title;
		
		// include layout and send it to client
		include $tp;
	}
	/**
	 *  set value from controller to use in template
	 * @param $varName {String} variable name
	 * @param $variable {Any type} value of variable
	 * @return void
	 */
	public function set($varName,$variable){
		$this->valiables[$varName] = $variable;
	}
}
//===============================================================

// BLOCK OF CODE WHAT
// PARSE URL AND CALL CONTROLLER AND CALL RENDER FUNCTION

	// connect to database
	include 'app/Config/core.php';
	
	//get required url
	$url = $_SERVER['REQUEST_URI'];
	
	$matches = array(); // variale for preg_match_all function
	preg_match_all('/[^\/]+?(?=\/|$)/',$url,$matches); // farse required url
	$url = $matches[0];
	if (isset($url[0])){ $url[0] = ucfirst($url[0]); } // set Upper first letter for controller name
	else { $url[0] = 'Item'; $url[1] = 'index'; } //TODO need to create default page
	
	
	$controller = $url[0].'Controller'; // record name of controller class
	
	$action = (isset($url[1])) ? $url[1] : 'index'; // if action does not exist set as default 'index' action
	
	try {
		$controller_f = 'app/Controller/'.$url[0].'Controller.php'; // record path to controller into variable
		if(!file_exists($controller_f)){ // if controller does not exist throw exception
			throw new Exception('controler file does not exist!');
		}
		include $controller_f;
		
		if (!class_exists($controller)){
			throw new Exception('controler class does not exist!');
		}
		
		$c = new $controller($url[0]);
		
		if (!$c instanceof Controller){ // if $c is not extend Controller throw Exception
				throw new Exception('error: cotroller '.$v.' is not extends from Controller class!');
		}
		
		// cheack action on controller and if it is not exist throw exception
		if (!method_exists($c,$action)){
			throw new Exception('action does not exist!');
		}

		// run action from controller
		$c->$action();
		
		// run render function
		$c->render('app/View/'.$url[0].'/'.$action.'.tp');

	} catch(Exception $e){
		echo '<p>'.$e->getMessage().'</p>';
	}
?>