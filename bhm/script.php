#!/usr/bin/php
<?php
// read from stdin
$fd = fopen("php://stdin", "r");
$eml = "";
while (!feof($fd)) {
    $eml .= fread($fd, 1024);
}
fclose($fd);
require_once("bounce_driver.class.php");
$bouncehandler = new Bouncehandler();
$bounce = $eml;
$log = fopen('/tmp/log.txt', 'a');
$multiArray = $bouncehandler->get_the_facts($bounce);
 if(   !empty($multiArray[0]['action'])
               && !empty($multiArray[0]['status'])
               && !empty($multiArray[0]['recipient']) ){
               fputs($log, "passed");
            }
            else {
                fputs($log, "failed");
       		}
fclose($log);
?>
