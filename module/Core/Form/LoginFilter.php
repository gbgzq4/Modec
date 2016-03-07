<?php
namespace Core\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
	public function __construct($serviceLocator)
	{
		  $this->add(array(
				'name'     => 'username',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'	  => 1,
							'max'	  => 50,
						),
					),
				),
			));

			$this->add(array(
				'name'     => 'password',
				'required' => true,
				'filters'  => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),
				),
				'validators' => array(
					array(
						'name'    => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min'      => 1,
						),
					),
				),
			));
	}
}