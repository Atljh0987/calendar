<?php
  require 'db.php';

  $data = $_POST;

  $tt = R::getAll( "SELECT title, start_event, end_event, commentary FROM timetables where user='" .  $_SESSION['logged_user']->login ."'");

  $file = "test.txt";
  $txt = fopen($file, "w") or die("Unable to open file!");
  foreach($tt as $el) {
    $st = new DateTime($el['start_event']);
    $ed = new DateTime($el['end_event']);
    $text = $el['title'] . ' ' .$st->format('Y-m-d H:i'). ' ' . $ed->format('Y-m-d H:i') . ' ' . $el['commentary'] . PHP_EOL;
    fwrite($txt, $text);
  }
  fclose($txt);
  
  header('Content-Description: File Transfer');
  header('Content-Disposition: attachment; filename='.basename($file));
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($file));
  header("Content-Type: text/plain");
  readfile($file);
?>