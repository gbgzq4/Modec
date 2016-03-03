<?php
namespace Application\Model;

use Zend\Crypt\Password\Bcrypt;

class UserPassword
{

	public $salt = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXX';

	public $method = 'none';//'sha1' by default

	/**
	 * Constructor
	 *
	 * @author Arvind Singh
	 * @access public
	 *        
	 * @param string $method
	 *            // Encryption method
	 * @return void
	 */
	public function __construct($method = null)
	{
		if (! is_null($method)) {
			$this->method = $method;
		}
	}

	/**
	 * Create Password
	 *
	 * @author Arvind Singh
	 * @access public
	 *        
	 * @param string $password
	 *            User Password
	 * @return string
	 */
	public function create($password)
	{
		if ($this->method == 'md5') {
			return md5($this->salt . $password);
		} elseif ($this->method == 'sha1') {
			return sha1($this->salt . $password);
		} elseif ($this->method == 'bcrypt') {
			$bcrypt = new Bcrypt();
			$bcrypt->setCost(14);
			return $bcrypt->create($password);
		} elseif ($this->method == 'none') {
			return $password;
		}
	}

	/**
	 * Validate the user password
	 *
	 * @author Arvind Singh
	 * @access public
	 *        
	 * @param string $password
	 *            // Password string
	 *            
	 * @param string $hash
	 *            // Hash string
	 *            
	 * @return boolean
	 */
	public function verify($password, $hash)
	{
		if ($this->method == 'md5') {
			return $hash == md5($this->salt . $password);
		} elseif ($this->method == 'sha1') {
			return $hash == sha1($this->salt . $password);
		} elseif ($this->method == 'bcrypt') {
			$bcrypt = new Bcrypt();
			$bcrypt->setCost(14);
			return $bcrypt->verify($password, $hash);
		}
	}
}

?>