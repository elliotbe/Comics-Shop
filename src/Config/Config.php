<?php
namespace App\Config;

class Config {

  private $config = [];

  public function __construct($config_file_list = []) {
    foreach ($config_file_list as $config_file) {
      $this->parseConfigFile($config_file);
    }
  }

  public function parseConfigFile(string $file) {
    if (file_exists($file) === false) {
      throw new ConfigException("No config file named $file", 1);
    }

    $file_content = file_get_contents($file);
    $file_array = (explode("\n", $file_content));
    $found_config_flag = false;
    foreach ($file_array as $line) {
      if (strpos($line, '=') !== false) {
        $constant = explode('=', $line);
        $this->config[trim($constant[0])] = trim($constant[1]);
        $found_config_flag = true;
      }
    }

    if ($found_config_flag === false) {
      throw new ConfigException("No config declaration found in $file", 2);
    }
  }

  public function get(string $key) :?string {
    return $this->config[$key] ?? null ;
  }

}
