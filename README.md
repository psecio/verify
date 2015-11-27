## Verify: Framework Agnostic Authentication & Authorization

The goal of the `Verify` library is to provide a structure for good authorization and authentication practices using your own data sources. `Verify` provides interfaces you can program to and inject your own objects and data into the tool for evaluation.

### Example Code

```php
<?php

// First we have the user from our own source (like an Eloquent record instance)
// with a "get" method defined

class MyUser
{
  protected $properties = [
    'username' => 'ccornutt',
    'password' => '$2y$10$tt3pnrzyAg81RCtKmSgEC.cRIGjfcGacE3VthMaotO.wZhupZQdmG'
  ];

  public function get($propertyName)
  {
    return $this->properties[$propertyName];
  }
}

// Then we inject this user into one based on the Verify "subject" interface
class User implements \Psecio\Verify\Subject
{
  private $user;

  public function __construct($user)
  {
      $this->user = $user;
  }

  public function getIdentifier()
  {
    return $this->user->get('username');
  }

  public function getCredential()
  {
    return $this->user->get('password');
  }
}

// -- Now to put it to use.... -------------------
$myUser = new MyUser();
$subject = new User($myUser);

$password = 'test';

$enforcer = \Psecio\Verify\Enforcer::make('password');
$result = $enforcer->login($subject, $password);

if ($result === true) {
  echo 'Login valid!';
}
?>
```

### Verifiers:

- `password`
