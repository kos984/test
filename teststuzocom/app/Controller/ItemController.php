<?php
	class ItemController extends Controller{
		public $uses = array('Item','Paren');
		
		public function index1(){
			$this->title = 'hello MVC '.$this->title;
			$items = $this->Paren->find(array('fields' => array('Item.id','Item.name','Item.parent_id','Paren.parent_name'),'order'=>array('Paren.parent_name')));
			//$this->set('items',$items);
		}
		
		public function index(){
			$this->title = 'hello MVC '.$this->title;
			$items = $this->Item->find(array('fields' => array('Item.id','Item.name','Item.parent_id','Paren.parent_name'),'order'=>array('Paren.parent_name')));
			$this->set('items',$items);
		}
		public function var1(){
			$this->title = 'hello MVC '.$this->title;
			$items = $this->Item->find();
			$this->set('items',$items);
		}
		public function var2(){
			$this->title = 'hello MVC '.$this->title;
			$items = $this->Item->find();
			$this->set('items',$items);
		}
		public function full(){
			$this->title = 'hello MVC '.$this->title;
			$items = $this->Item->find();
			$this->set('items',$items);
		}
		public function ajaxtest(){
			$this->layout = 'ajax';
			$this->title = 'hello MVC '.$this->title;
			$items = $this->Item->find();
			echo json_encode($items);
		}
	}
?>