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
$bounce = file_get_contents("eml/".$_GET['eml']);
$multiArray = $bouncehandler->get_the_facts($bounce);
$bounce = $bouncehandler->init_bouncehandler($bounce, 'string');
list($head, $body) = preg_split("/\r\n\r\n/", $bounce, 2);
?>
