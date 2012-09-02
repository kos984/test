<?php 
class Item1Controller extends Controller{
	public $uses = array('Item');
	
	public function index(){
		$this->title = 'hello MVC '.$this->title;
		$items = $this->Item->find();
		$this->set('items',$items);
	}
}
?>