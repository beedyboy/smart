<?php
/**
*
*/
class Menu extends Model
{

	function __construct($table)
	{
		# code...
		$table = "menu";
		parent::__construct($table);

		$col = $this->get_columns();

		// dnd($col);
	}
}