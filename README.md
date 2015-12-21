## Verify: Framework Agnostic Authentication & Authorization

[![Travis-CI Build Status](https://secure.travis-ci.org/psecio/verify.png?branch=master)](http://travis-ci.org/psecio/verify)

The goal of the `Verify` library is to provide a structure for good authorization and authentication practices using your own data sources. `Verify` provides interfaces you can program to and inject your own objects and data into the tool for evaluation.

### Example Code

First off, we're going to make a user based on an object we already have. In most cases the values on a user (model or otherwise) are referenced as properties. To make this creation easier, `Verify` has a `Simple` subject class you can use. You'll see this in the example below:

```php
<?php

$user = (object)[
  'username' => 'ccornutt',
  'password' => password_hash('test1234', PASSWORD_DEFAULT),
  'permissions' => ['test1', 'test2', 'edit']
];
$subject = new \Psecio\Verify\Subject\Simple($user);

// Now we'll set up our Gateway to work with our user and run some checks
$gate = new Gateway($subject);

// We can see if the password they entered matches
echo 'Password match? '.var_export($gate->authorize($_POST['password']), true);

// And we can check their permissions with the "can" and "cannot" checks
if ($gate->can('edit') && $gate->cannot('delete')) {
    echo "We're here!";
}

// Or we can make it a bit more complex and include multiple
if ($gate->can(['edit', 'test1']) && $gate->cannot(['bar', 'test2'])) {
    /* Won't get here, the user has "test" so it fails */
} else {
    echo "This one fails!";
}

// Or, if you'd like to build up more of a policy:
$gate->allow('edit')->deny('test1234');
if ($gate->evaluate() === true) {
    echo 'Pass with flying colors!';
}

?>
```

The `Verify` library makes use of the [PropAuth](https://github.com/psecio/propauth) library behind the scenes. This library has a much more powerful engine than is just used here. If you have more "power" needs, check it out.
