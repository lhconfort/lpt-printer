<?php

class Authorization {
  protected $headersParser;

  public function __construct() {
    $this->headersParser = new HeadersParser();
  }

  public function restrictAccess() {
    if ($this->headersParser->getAuthToken() != ACCESS_TOKEN) {
      header('HTTP/1.0 401 Unauthorized', true, 401);
      die();
    }
  }
}

?>
