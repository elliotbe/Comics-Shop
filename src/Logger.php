<?php
declare(strict_types = 1);
namespace App;

class Logger {

  private $log_file;

  public function __construct($filename) {
    $this->log_file = fopen($filename, 'a');
  }

  public function __destruct() {
    fclose($this->log_file);
  }

  public function write(\Throwable $th) {
    fwrite($this->log_file, date("d/m/y - H:i:s") . "\tCode {$th->getCode()} : {$th->getMessage()} - Line {$th->getLine()} in {$th->getFile()}\n");
  }

}
