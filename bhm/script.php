#!/usr/bin/php
<?php
// read from stdin
$mail_box = '{localhost:143/novalidate-cert}'; //imap example
$mail_user = '';
$mail_pass = '';
$conn = imap_open($mail_box, $mail_user, $mail_pass) or die(imap_last_error());
$num_msgs = imap_num_recent($conn);
$threshold = 4;
$log = fopen('/tmp/log.txt', 'a');
fputs($log,$num_msgs);
# start bounce class
require_once('bounce_driver.class.php');
$bouncehandler = new Bouncehandler();

# get the failures
$email_addresses = array();
$delete_addresses = array();
  for ($n=1;$n<=$num_msgs;$n++) {
  $bounce = imap_fetchheader($conn, $n).imap_body($conn, $n); //entire message
  $multiArray = $bouncehandler->get_the_facts($bounce);
    if (!empty($multiArray[0]['action']) && !empty($multiArray[0]['status']) && !empty($multiArray[0]['recipient']) ) {
      if ($multiArray[0]['action']=='failed') {
      $email_addresses[$multiArray[0]['recipient']]++; //increment number of failures
      $delete_addresses[$multiArray[0]['recipient']][] = $n; //add message to delete array
      } //if delivery failed
    } //if passed parsing as bounce
  } //for loop

# process the failures
  foreach ($email_addresses as $key => $value) { //trim($key) is email address, $value is number of failures
    if ($value>=$threshold) {
	fpusts($log,"threshold reached");    
    # mark for deletion
      foreach ($delete_addresses[$key] as $delnum) imap_delete($conn, $delnum);
    } //if failed more than $delete times
  } //foreach

fclose($log);
# delete messages
imap_expunge($conn);

#close imap connection
imap_close($conn);

?>
