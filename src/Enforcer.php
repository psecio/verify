<?php

namespace Psecio\Verify;

abstract class Enforcer
{
  private static $types = [
    'password' => '\\Enforcer\\Authenticator\\Password'
  ];

  public abstract function evaluate();

  public static function make($type, $context = [])
  {
    $type = strtolower($type);
    if (!array_key_exists($type, self::$types)) {
      throw new \Exception('Invalid enforcer type: '.$type);
    }
    $typeNs = '\\Psecio\\Verify'.self::$types[$type];
    return new $typeNs($context);
  }
}
