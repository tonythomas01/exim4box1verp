<?php
  protected function execute($arguments = array(), $options = array())
  {
    // read stdin
    $content = file_get_contents('php://stdin');
    $log = fopen('/tmp/log.txt', 'a');
    fputs($log, $arguments['address'] . "\n");
    fputs($log, "-----\n");
    fputs($log, $content);
    fputs($log, "-----\n\n\n");
    fclose($log);
  }
?>
