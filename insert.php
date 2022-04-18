<?php
  require 'db.php';

  $data = $_POST;

  if(isset($data["title"])) {
    $tt = R::dispense('timetables');
    $tt->user = $_SESSION['logged_user']->login;
    $tt->userId = $_SESSION['logged_user']->id;
    $tt->title = $data['title'];
    $tt->start_event = $data['start'];
    $tt->end_event = $data['end'];
    $tt->commentary = $data['commentary'];
    R::store($tt);
  }
?>