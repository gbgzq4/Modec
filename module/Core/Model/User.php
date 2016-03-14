<?php

namespace Core\Model;

class User extends AbstractModel
{
	public $userid;
	public $username;
	public $email;
	public $password;
	public $password_salt;
	public $usergroup;
	
	
	
	
	
	
	
	
	
	public function __construct($data = null) 
	{
		if ($data) {
			foreach ($this as $key => $value) {
				$this->$key = (!empty($data->$key)) ? $data->$key : null;
			}
		}
	}
	
	public function exchangeArray(Array $data) 
	{
		foreach ($this as $key => $value) {
			$this->$key = (!empty($data[$key])) ? $data[$key] : null;
		}
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}