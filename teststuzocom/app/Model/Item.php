<?php
class Item extends Model{
	public $name="Item";

	public $belongsTo = array(
		'Paren'=>array(
			'className'=>'Paren',
			'foreignKey'=>'parent_id'
        )
	);
}
?>