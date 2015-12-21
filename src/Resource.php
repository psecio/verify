<?php

namespace Psecio\Verify;

class Resource
{
  protected $uri;
  protected $httpMethod;

  public function __construct($uri = null, $httpMethod = null)
  {
    $uri = ($uri !== null) ?: $_SERVER['REQUEST_URI'];
    $this->setUri($uri);

    $httpMethod = ($httpMethod !== null) ?: $_SERVER['REQUEST_METHOD'];
    $this->setHttpMethod($httpMethod);
  }

  public function setUri($uri)
  {
    $this->uri = $uri;
  }

  public function setHttpMethod($method)
  {
    $this->httpMethod = $method;
  }
}
