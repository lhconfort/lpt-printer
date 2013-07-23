<?php

class HeadersParser {
  protected $authToken;

  public function __construct() {
    $this->authToken = $this->parseAuthToken();
  }

  public function getAuthToken() {
    return $this->authToken;
  }

  private function parseAuthToken() {
    $headers = getallheaders();
    $auth = trim($headers['Authorization']);
    $auth_begin = 'Token token=';

    if (strpos($auth, $auth_begin) != 0) return null;
    $auth = substr_replace($auth, '', 0, strlen($auth_begin));
    if (strlen($auth) < 2) return null;

    $allowed_separators = array('"', "'");

    if (!in_array($auth[0], $allowed_separators)) return null;
    if ($auth[0] != substr($auth, -1)) return null;

    return substr($auth, 1, -1);
  }
}

?>
