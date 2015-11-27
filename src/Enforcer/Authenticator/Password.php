<?php

namespace Psecio\Verify\Enforcer\Authenticator;

class Password extends \Psecio\Verify\Enforcer\Authenticator
{
  public function evaluate()
  {
    $user = $this->getContext('user');
		$password = $this->getContext('password');
    
		if ($user === null || $password === null) {
			throw new \Exception('Invalid username or password!');
		}
		// Compare the values
		return password_verify($password, $user->getCredential());
  }

  public function login(\Psecio\Verify\Subject $user, $password)
  {
    $this->setContext([
			'user' => $user,
			'password' => $password
		]);
		return $this->evaluate();
  }
}
