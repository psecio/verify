<?php

namespace Psecio\Verify;
use Psecio\PropAuth\Policy;
use Psecio\PropAuth\PolicySet;
use \Psecio\PropAuth\Enforcer as PropAuthEnforcer;

class Gateway
{
  protected $subject;
  protected $resource;
  protected $currentPolicy;

  const DEFAULT_POLICY = 'default';
  protected $policies;

  public function __construct(Subject $subject, $resource = null)
  {
    $this->setSubject($subject);

    $resource = ($resource !== null) ?: new Resource();
    $this->setResource($resource);

    $this->policy = new Policy();

    // Make the policy set and create a default
    $this->policies = new PolicySet();
    $this->policies->add('default', new Policy());
  }

  public function setSubject(Subject $subject)
  {
    $this->subject = $subject;
  }
  public function getSubject()
  {
    return $this->subject;
  }
  public function setResource(Resource $resource)
  {
    $this->resource = $resource;
  }
  public function getResource()
  {
    return $this->resource;
  }

  public function evaluate($policyName = null)
  {
    $enforcer = new PropAuthEnforcer();

    $policy = ($policyName == null) ? $this->policies[self::DEFAULT_POLICY] : $this->policies[$policyName];
    $result = $enforcer->evaluate($this->getSubject(), $policy);

    return $result;
  }

  public function policy($policyName)
  {
    if ($this->policies[$policyName] === null) {
        $this->policies->add($policyName, new Policy());
    }
    return $this->policies[$policyName];
  }

  public function allow($permName, $policyName = null)
  {
    $policyName = ($policyName !== null) ? $policyName : self::DEFAULT_POLICY;
    $this->policy($policyName)->hasPermissions($permName);

    return $this;
  }

  public function deny($permName, $policyName = null)
  {
    $policyName = ($policyName !== null) ? $policyName : self::DEFAULT_POLICY;
    $this->policy($policyName)->notPermissions($permName);

    return $this;
  }

  public function can($permName)
  {
      $policy = Policy::instance()->hasPermissions($permName);
      $enforcer = new PropAuthEnforcer();

      $result = $enforcer->evaluate($this->getSubject(), $policy);
      return $result;
  }

  public function cannot($permName)
  {
      return (!$this->can($permName));
  }

  public function authorize($password)
  {
      $enforcer = Enforcer::make('password');
      $result = $enforcer->login($this->getSubject(), $password);

      return $result;
  }
}
