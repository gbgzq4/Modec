<?php

namespace Core\Model;

abstract class AbstractModel
{
	public function __construct($data = null) 
	{
		if ($data) {		
			$this->populate($data);
		}
	}

	public function exchangeArray(Array $data) 
	{
		// Keep a copy to return
		$return = $this->getArrayCopy();

		// Copy the data
		$this->_populate($data);
		
		// Return the copy
		return $return;
	}

	public function populate($data)
	{
		// Make sure the data is an array
		if (is_object($data)) {
			if (method_exists($data, 'getArrayCopy')) {
				$data = $data->getArrayCopy();
			} else {
				$data = get_object_vars($data);
			}
		}

		// Copy the data
		$this->_populate($data);
	}

	protected function _populate(Array $data)
	{
		foreach ($this as $key => $value) {
			$this->__set($key, (!empty($data[$key])) ? $data[$key] : null);
		}
	}

	public function getArrayCopy()
	{
		$return = array();
		
		foreach ($this as $key => $value) {
			$return[$key] = $this->__get($key);
		}

		return $return;
	}

	public function __get($name)
	{
		// Check for a custom getter and use it		
		if (method_exists($this, 'get' . $name)) {
			return $this->{'get' . $name}();
		}

		// Return the value
		return $this->$name;
	}

	public function __set($name, $value)
	{
		// Check for a custom setter and use it
		if (method_exists($this, 'set' . $name)) {
			$this->{'set' . $name}($value);
			return;
		}

		// Set the value
		$this->$name = $value;
	}

    function __isset($name)
	{
        return isset($this->$name);
    }

    function __unset($name)
	{
        unset($this->$name);
    }
}
