<?php

class LptPrinter {
  private $port;
  private $printer_path;

  public function __construct($port, $printer_path) {
    $this->port = $port;
    $this->printer_path = $printer_path;
  }

  public function print($uploaded_tmp_file) {
    $tmp_path = TMP_FOLDER . RandomToken::create(30) . '.txt';
    move_uploaded_file($uploaded_tmp_file, $tmp_path);

    shell_exec('net use ' . $this->port . ': /delete 2>&1');

    $cmd_output = shell_exec('net use ' . $this->port . ': ' . $this->printer_path . ' 2>&1');

    if (!preg_match('/^The command completed successfully/', $cmd_output)) {
      return array('success' => false, 'message' => 'Network printer does not exists.');
    }

    $cmd_output = shell_exec('copy /b ' . $tmp_path . ' ' . $this->port . ' 2>&1');

    if (!preg_match('/1 file\(s\) copied/', $cmd_output)) {
      return array('success' => false, 'message' => 'Could not send data to printer.');
    }

    shell_exec('net use ' . $this->port . ': /delete 2>&1');
    @unlink($tmp_path);

    return array('success' => true, 'message' => 'Receipt sent to printer.');
  }
}

?>
