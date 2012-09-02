<?php
class Paren extends Model{
	public $name="Paren";

	public $hasMany= array(
		'Item'=>array(
			'className'=>'Item',
			'foreignKey'=>'parent_id'
        )
	);
}
?>