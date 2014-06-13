#!/usr/bin/php
<?php
// read from stdin
$mail_box = '{localhost:143/novalidate-cert}'; //imap example
$mail_user = 'tonythomas01';
$mail_pass = 'router69';
$conn = imap_open($mail_box, $mail_user, $mail_pass) or die(imap_last_error());
$num_msgs = imap_num_recent($conn);
$log = fopen('/tmp/log.txt', 'a');
fputs( $log,$num_msgs );
fclose($log);
imap_close($conn);
?>
