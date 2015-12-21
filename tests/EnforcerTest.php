<?php

namespace Psecio\Verify;
include_once __DIR__.'/TestEnforcer.php';

class EnforcerTest extends \PHPUnit_Framework_TestCase
{
  public function testCreateNewVerifierValid()
  {
    $type = 'password';
    $result = TestEnforcer::make($type);

    // Verify it's an Authenticator
    $this->assertInstanceOf('\Psecio\Verify\Enforcer\Authenticator', $result);

    // Verify it's a Password type too
    $this->assertInstanceOf('\Psecio\Verify\Enforcer\Authenticator\Password', $result);
  }
}
