<?php
/*
| -----------------------------------------------------
| PRODUCT NAME: 	MODERN POS
| -----------------------------------------------------
| AUTHOR:			itsolution24.COM
| -----------------------------------------------------
| EMAIL:			info@itsolution24.com
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY itsolution24.COM
| -----------------------------------------------------
| WEBSITE:			http://itsolution24.com
| -----------------------------------------------------
*/
final class Registry 
{
	private $data = array();

	public function get($key) 
	{
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}

	public function set($key, $value) 
	{
		$this->data[$key] = $value;
	}

	public function has($key) 
	{
		return isset($this->data[$key]);
	}
}