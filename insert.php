<?php
  require 'db.php';

  $data = $_POST;

  if(isset($data["title"])) {
    $tt = R::dispense('timetables');
    $tt->user = $_SESSION['logged_user']->login;
    $tt->title = $data['title'];
    $tt->start_event = $data['start'];
    $tt->end_event = $data['end'];
    R::store($tt);
  }
?>