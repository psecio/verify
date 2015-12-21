<?php

namespace Psecio\Verify\Enforcer\Authenticator;

class PasswordTest extends \PHPUnit_Framework_TestCase
{
  private $enforcer;

  public function setUp()
  {
    $this->enforcer = \Psecio\Verify\TestEnforcer::make('password');
  }

  public function tearDown()
  {
    unset($this->enforcer);
  }

  /**
   * Test the evaluation of the password, passes because they match
   */
  public function testValidPasswordEvaluation()
  {
    $password = 'testing12345';
    $user = (object)[
      'username' => 'testing',
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    $subject = new TestSubject($user);
    $result = $this->enforcer->login($subject, $password);
    $this->assertTrue($result);
  }

  /**
   * Test the evaluation of the password, fails because of no match
   */
  public function testInvalidPasswordEvaluation()
  {
    $password = 'testing12345';

    $user = (object)[
      'username' => 'testing',
      'password' => password_hash('other password', PASSWORD_DEFAULT)
    ];

    $subject = new TestSubject($user);
    $result = $this->enforcer->login($subject, $password);
    $this->assertFalse($result);
  }
}

// ----- Supporting classes --------
class MyUser
{
  public $username = 'test';
  public $password;
}

class TestSubject implements \Psecio\Verify\Subject
{
  private $user;

  public function __construct($user)
  {
    $this->user = $user;
  }
  public function getIdentifier()
  {
    return $this->user->username;
  }
  public function getCredential()
  {
    return $this->user->password;
  }
}
