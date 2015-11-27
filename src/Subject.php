<?php

namespace Psecio\Verify;

interface Subject
{
  public function getIdentifier();
  public function getCredential();
}
