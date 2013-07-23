<?php

class RandomToken {
  public static function create($length) {
    $charset = str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length);
    return substr(str_shuffle($charset), 0, $length);
  }
}

?>
