<?php

class Sale extends Model
{

	function __construct($table)
	{
		# code...

		parent::__construct($table);

		$col = $this->get_columns();

	}
}