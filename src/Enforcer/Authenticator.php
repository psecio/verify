<?php

namespace Psecio\Verify\Enforcer;

abstract class Authenticator extends \Psecio\Verify\Enforcer
{
	protected $context = [];
  
	public function __construct($context = array())
	{
		if (!empty($context)) {
			$this->setContext($context);
		}
	}
	public function setContext(array $context)
	{
		$this->context = $context;
	}
	public function getContext($property = null)
	{
		if ($property !== null) {
			return (isset($this->context[$property])) ? $this->context[$property] : null;
		} else {
			return $this->context;
		}
	}
}
