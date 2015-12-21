<?php

namespace Psecio\Verify;

interface Subject
{
  /**
   * Get the identifier for the subject (usually username)
   * @return string identifier
   */
  public function getIdentifier();

  /**
   * Get the credential value for the subject (like password)
   * @return string Credential
   */
  public function getCredential();

  /**
   * Get the groups list for the subject (set of strings)
   * @return array Set of group names
   */
  public function getGroups();

  /**
   * Get the permissions list for the subject (set of strings)
   * @return array Set of permission names
   */
  public function getPermissions();
}
