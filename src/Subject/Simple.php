<?php

namespace Psecio\Verify\Subject;
use \Psecio\Verify\Subject;

class Simple implements Subject
{
  private $subject;

  public function __construct($subject)
  {
      $this->subject = $subject;
  }

  public function getIdentifier()
  {
    return $this->subject->username;
  }

  public function getCredential()
  {
    return $this->subject->password;
  }

  public function getGroups()
  {
    return $this->subject->groups;
  }

  public function getPermissions()
  {
    return $this->subject->permissions;
  }
}
